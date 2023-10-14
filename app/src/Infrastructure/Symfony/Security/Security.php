<?php

namespace Infrastructure\Symfony\Security;

use Domain\Shared\Gateway\SecurityInterface;
use Domain\User\Entity\User;
use Symfony\Bundle\SecurityBundle\Security as BaseSecurity;

final readonly class Security implements SecurityInterface
{
    public function __construct(private BaseSecurity $security)
    {
    }

    public function login(User $user): void
    {
        $securityUser = new SecurityUser($user);

        $this->security->login($securityUser);
    }

    public function logout(): void
    {
        if (!$this->getLoggedUser()) {
            return;
        }

        $this->security->logout(false);
    }

    public function getLoggedUser(): ?User
    {
        /** @var SecurityUser|null $user */
        $user = $this->security->getUser();

        return $user?->getUser();
    }
}
