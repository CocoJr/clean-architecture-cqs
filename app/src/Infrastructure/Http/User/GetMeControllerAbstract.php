<?php

namespace Infrastructure\Http\User;

use Application\Gateway\User\UserUseCaseBus;
use Application\UseCase\User\GetLogged\GetLoggedUserRequest;
use Infrastructure\Http\AbstractHttpController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class GetMeControllerAbstract extends AbstractHttpController
{
    #[Route('/users/me', name: 'user_me', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function __invoke(UserUseCaseBus $userUseCaseBus): Response
    {
        return $this->render('users/me.html.twig', [
            'user' => $userUseCaseBus->getLogged(new GetLoggedUserRequest())->user,
        ]);
    }
}
