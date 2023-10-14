<?php

namespace Domain\User\UseCase\Login;

final readonly class LoginUserRequest
{
    public function __construct(
        public string $email,
        public string $password
    ) {
    }
}
