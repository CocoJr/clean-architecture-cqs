<?php

namespace Infrastructure\Http\User;

use Application\Gateway\MessageBusInterface;
use Application\UseCase\User\Login\LoginUserRequest;
use Domain\User\Error\UserLoginFailedException;
use Domain\User\Error\UserNotExistsException;
use Domain\User\Value\Email;
use Domain\User\Value\Password;
use Infrastructure\Http\AbstractHttpController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class LoginUserControllerAbstract extends AbstractHttpController
{
    #[Route('/users/login', name: 'user_login', methods: ['POST'])]
    public function __invoke(Request $request, MessageBusInterface $messageBus): Response
    {
        $formErrors = [];
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
            $this->addFlash('error', 'login.error');

            return $this->redirectToRoute('home');
        }

        try {
            $messageBus->send(new LoginUserRequest(
                $email,
                $password,
            ));

            $this->addFlash('success', 'login.success');

            return $this->redirectToRoute('user_me');
        } catch (UserNotExistsException|UserLoginFailedException $e) {
            $this->addFlash('error', 'login.error');
        }

        return $this->redirectToRoute('home');
    }
}
