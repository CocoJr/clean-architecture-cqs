<?php

namespace Domain\User\Query\GetByEmail;

use Domain\User\Entity\User;

final readonly class GetUserByEmailResponse
{
    public function __construct(public ?User $user)
    {
    }
}
