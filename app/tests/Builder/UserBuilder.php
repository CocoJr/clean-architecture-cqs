<?php

namespace Tests\Builder;

use Domain\User\Model\User;
use Domain\User\Value\Email;
use Domain\User\Value\Password;
use Domain\User\Value\Role;
use Domain\User\Value\Roles;
use Domain\User\Value\Username;

final class UserBuilder extends AbstractBuilder
{
    private string $password;

    public function withPassword(string $password): UserBuilder
    {
        $this->password = $password;

        return $this;
    }

    public function build(): User
    {
        $user = new User();
        $user->setUsername(new Username($this->faker->unique()->userName()));
        $user->setEmail(new Email($this->faker->unique()->email()));
        $user->setPlainPassword(new Password($this->password ?? $this->faker->password()));
        $user->setRoles(
            new Roles(
                new Role('ROLE_USER')
            )
        );

        return $user;
    }
}
