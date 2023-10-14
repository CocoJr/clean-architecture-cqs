<?php

namespace Domain\User\Query\GetByEmail;

final readonly class GetUserByEmailRequest
{
    public function __construct(
        public string $email
    ) {
    }
}
