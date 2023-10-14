<?php

namespace Application\UseCase\User\Login;

use Domain\User\Model\User;

final readonly class LoginUserResponse
{
    public function __construct(public User $user)
    {
    }
}
