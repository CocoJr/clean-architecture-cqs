<?php

declare(strict_types=1);

namespace Domain\User\Value;

use Domain\Shared\Error\ValidationException;

class Username
{
    private string $username;

    public function __construct(string $username)
    {
        if (strlen($username) < 3 || strlen($username) > 20) {
            throw new ValidationException(['username' => 'validation.username.length']);
        }

        $this->username = $username;
    }

    public function getValue(): string
    {
        return $this->username;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
