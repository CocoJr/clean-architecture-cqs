<?php

namespace Application\UseCase\User\Register;

use Domain\User\Value\Email;
use Domain\User\Value\Password;
use Domain\User\Value\Username;

final readonly class RegisterUserRequest
{
    public function __construct(
        public Username $username,
        public Email $email,
        public Password $password
    ) {
    }
}
