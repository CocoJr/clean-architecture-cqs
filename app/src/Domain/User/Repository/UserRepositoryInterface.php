<?php

namespace Domain\User\Repository;

use Domain\User\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): User;

    public function getByEmail(string $email): ?User;

    public function getById(int $id): ?User;
}
