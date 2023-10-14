<?php

declare(strict_types=1);

namespace Domain\User\Value;

use Domain\Shared\Error\ValidationException;

class Password
{
    private string $password;

    public function __construct(string $password)
    {
        if (strlen($password) < 4 || strlen($password) > 100) {
            throw new ValidationException(['password' => 'validation.password.length']);
        }

        $this->password = $password;
    }

    public function getValue(): string
    {
        return $this->password;
    }
}
