<?php

namespace Domain\User\UseCase\Login;

use Domain\User\Entity\User;

final readonly class LoginUserResponse
{
    public function __construct(public User $user)
    {
    }
}
