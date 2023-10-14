<?php

namespace Infrastructure\Http\User;

use Application\Gateway\MessageBusInterface;
use Application\UseCase\User\Logout\LogoutUserRequest;
use Infrastructure\Http\AbstractHttpController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class LogoutUserControllerAbstract extends AbstractHttpController
{
    #[Route('/users/logout', name: 'user_logout', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function __invoke(MessageBusInterface $messageBus): Response
    {
        $messageBus->send(new LogoutUserRequest());

        return $this->redirectToRoute('home');
    }
}
