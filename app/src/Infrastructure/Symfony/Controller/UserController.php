<?php

namespace Infrastructure\Symfony\Controller;

use Domain\Shared\Exception\ValidationException;
use Domain\Shared\Gateway\MessageBusInterface;
use Domain\Shared\Gateway\SecurityInterface;
use Domain\User\Exception\UserAlreadyExistsException;
use Domain\User\Exception\UserLoginFailedException;
use Domain\User\Exception\UserNotExistsException;
use Domain\User\UseCase\Login\LoginUserRequest;
use Domain\User\UseCase\Logout\LogoutUserRequest;
use Domain\User\UseCase\Register\RegisterUserRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/users')]
final class UserController extends AbstractController
{
    #[Route('/me', name: 'user_me', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function me(SecurityInterface $security): Response
    {
        return $this->render('users/me.html.twig', [
            'user' => $security->getLoggedUser(),
        ]);
    }

    #[Route('/', name: 'user_register', methods: ['POST'])]
    public function register(Request $request, MessageBusInterface $messageBus, SecurityInterface $security): Response
    {
        try {
            $messageBus->send(new RegisterUserRequest(
                $request->get('username', ''),
                $request->get('email', ''),
                $request->get('password', ''),
            ));

            $messageBus->send(new LoginUserRequest(
                $request->get('email'),
                $request->get('password'),
            ));

            $this->addFlash('success', 'register.success');

            return $this->redirectToRoute('user_me');
        } catch (ValidationException $exception) {
            $formErrors = $exception->getErrors();
        } catch (UserAlreadyExistsException $e) {
            $formErrors = ['email' => 'user.exists'];
        }

        return $this->redirectToRoute('home', ['form' => 'register', 'form_errors' => $formErrors]);
    }

    #[Route('/login', name: 'user_login', methods: ['POST'])]
    public function login(Request $request, MessageBusInterface $messageBus): Response
    {
        try {
            $messageBus->send(new LoginUserRequest(
                $request->get('email', ''),
                $request->get('password', ''),
            ));

            $this->addFlash('success', 'login.success');

            return $this->redirectToRoute('user_me');
        } catch (UserNotExistsException|UserLoginFailedException $e) {
            $this->addFlash('error', 'login.error');
        }

        return $this->redirectToRoute('home');
    }

    #[Route('/logout', name: 'user_logout', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function logout(MessageBusInterface $messageBus): Response
    {
        $messageBus->send(new LogoutUserRequest());

        return $this->redirectToRoute('home');
    }
}
