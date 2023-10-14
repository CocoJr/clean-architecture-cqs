<?php

namespace Application\UseCase\User\Login;

use Domain\User\Value\Email;
use Domain\User\Value\Password;

final readonly class LoginUserRequest
{
    public function __construct(
        public Email $email,
        public Password $password
    ) {
    }
}
