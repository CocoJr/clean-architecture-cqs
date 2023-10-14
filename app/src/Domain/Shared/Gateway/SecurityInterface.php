<?php

namespace Domain\Shared\Gateway;

use Domain\User\Entity\User;

interface SecurityInterface
{
    public function login(User $user): void;

    public function logout(): void;

    public function getLoggedUser(): ?User;
}
