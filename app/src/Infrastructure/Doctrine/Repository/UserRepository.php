<?php

namespace Infrastructure\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\User\Entity\User;
use Domain\User\Repository\UserRepositoryInterface;

final class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $user): User
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return $user;
    }

    public function getByEmail(string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function getById(int $id): ?User
    {
        return $this->find($id);
    }
}
