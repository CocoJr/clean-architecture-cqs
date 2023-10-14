<?php

declare(strict_types=1);

namespace Domain\User\Value;

class Roles
{
    /** @var iterable|Role[] */
    private iterable $roles;

    public function __construct(Role ...$roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return iterable<string>
     */
    public function getValue(): iterable
    {
        $roles = [];

        foreach ($this->roles as $role) {
            $roles[] = $role->getValue();
        }

        return $roles;
    }
}
