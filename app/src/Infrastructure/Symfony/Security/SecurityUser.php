<?php

namespace Infrastructure\Symfony\Security;

use Domain\User\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

final readonly class SecurityUser implements UserInterface
{
    public function __construct(private User $user)
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getRoles(): array
    {
        return $this->user->getRoles();
    }

    public function getUserIdentifier(): string
    {
        return $this->user->getEmail();
    }

    public function eraseCredentials(): void
    {
        throw new \Exception('Not implemented');
    }
}
