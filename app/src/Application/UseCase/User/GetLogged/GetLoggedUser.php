<?php

namespace Application\UseCase\User\GetLogged;

use Application\Gateway\SecurityInterface;

final readonly class GetLoggedUser
{
    public function __construct(private SecurityInterface $security)
    {
    }

    public function __invoke(GetLoggedUserRequest $request): GetLoggedUserResponse
    {
        $user = $this->security->getLoggedUser();

        return new GetLoggedUserResponse($user);
    }
}
