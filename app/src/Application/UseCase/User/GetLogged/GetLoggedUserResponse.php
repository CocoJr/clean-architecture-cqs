<?php

namespace Application\UseCase\User\GetLogged;

use Domain\User\Model\User;

final readonly class GetLoggedUserResponse
{
    public function __construct(public User $user)
    {
    }
}
