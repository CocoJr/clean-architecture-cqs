<?php

namespace Domain\User\Repository;

use Domain\User\Model\User;

interface UserRepositoryInterface
{
    public function save(User $user): User;

    public function getByEmail(string $email): ?User;
}
