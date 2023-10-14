<?php

namespace Infrastructure\Http\User;

use Application\Gateway\MessageBusInterface;
use Application\Gateway\SecurityInterface;
use Application\UseCase\User\Login\LoginUserRequest;
use Application\UseCase\User\Register\RegisterUserRequest;
use Domain\User\Error\UserAlreadyExistsException;
use Domain\User\Value\Email;
use Domain\User\Value\Password;
use Domain\User\Value\Username;
use Infrastructure\Http\AbstractHttpController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RegisterUserControllerAbstract extends AbstractHttpController
{
    #[Route('/users', name: 'user_register', methods: ['POST'])]
    public function __invoke(Request $request, MessageBusInterface $messageBus, SecurityInterface $security): Response
    {
        $formErrors = [];
        $username = $this->validateField(
            $request->get('username', ''),
            Username::class,
            $formErrors
        );
        $email = $this->validateField(
            $request->get('email', ''),
            Email::class,
            $formErrors
        );
        $password = $this->validateField(
            $request->get('password', ''),
            Password::class,
            $formErrors
        );

        if (!empty($formErrors)) {
            return $this->redirectToRoute('home', ['form' => 'register', 'form_errors' => $formErrors]);
        }

        try {
            $messageBus->send(new RegisterUserRequest(
                $username,
                $email,
                $password,
            ));
        } catch (UserAlreadyExistsException) {
            $formErrors = ['email' => 'user.exists'];

            return $this->redirectToRoute('home', ['form' => 'register', 'form_errors' => $formErrors]);
        }

        $messageBus->send(new LoginUserRequest(
            $email,
            $password,
        ));

        $this->addFlash('success', 'register.success');

        return $this->redirectToRoute('user_me');
    }
}
