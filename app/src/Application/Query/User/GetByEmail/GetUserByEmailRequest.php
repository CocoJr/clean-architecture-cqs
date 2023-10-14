<?php

namespace Application\Query\User\GetByEmail;

use Domain\User\Value\Email;

final readonly class GetUserByEmailRequest
{
    public function __construct(
        public Email $email
    ) {
    }
}
