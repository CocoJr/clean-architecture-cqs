<?php

namespace Application\Command\User\Create;

use Domain\User\Value\Email;
use Domain\User\Value\Password;
use Domain\User\Value\Roles;
use Domain\User\Value\Username;

final readonly class CreateUserRequest
{
    public function __construct(
        public Username $username,
        public Email $email,
        public Password $password,
        public Roles $roles,
    ) {
    }
}
