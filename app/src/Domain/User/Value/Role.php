<?php

declare(strict_types=1);

namespace Domain\User\Value;

use Domain\Shared\Error\ValidationException;

class Role
{
    public const ALLOWED_ROLES = ['ROLE_USER', 'ROLE_ADMIN'];

    private string $role;

    public function __construct(string $role)
    {
        if (!in_array($role, self::ALLOWED_ROLES)) {
            throw new ValidationException(['role' => 'validation.role.invalid']);
        }

        $this->role = $role;
    }

    public function getValue(): string
    {
        return $this->role;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
