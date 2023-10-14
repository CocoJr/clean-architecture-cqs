<?php

namespace Domain\User\Command\Create;

final readonly class CreateUserRequest
{
    public function __construct(
        public readonly string $username,
        public readonly string $email,
        public readonly string $password
    ) {
    }
}
