<?php

namespace Tests\Builder;

use Domain\User\Entity\User;

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
        $user->setUsername($this->faker->unique()->userName());
        $user->setEmail($this->faker->unique()->email());
        $user->setPassword($this->password ?? $this->faker->password());
        $user->setRoles(['ROLE_USER']);

        return $user;
    }
}
