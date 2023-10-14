<?php

namespace Application\Gateway;

use Domain\User\Model\User;

interface SecurityInterface
{
    public function login(User $user): void;

    public function logout(): void;

    public function getLoggedUser(): ?User;
}
