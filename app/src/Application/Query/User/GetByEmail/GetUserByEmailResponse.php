<?php

namespace Application\Query\User\GetByEmail;

use Domain\User\Model\User;

final readonly class GetUserByEmailResponse
{
    public function __construct(public ?User $user)
    {
    }
}
