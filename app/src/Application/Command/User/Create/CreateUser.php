<?php

namespace Application\Command\User\Create;

use Domain\User\Model\User;
use Domain\User\Repository\UserRepositoryInterface;

final readonly class CreateUser
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(CreateUserRequest $request): void
    {
        $user = new User();
        $user->setEmail($request->email);
        $user->setUsername($request->username);
        $user->setPlainPassword($request->password);
        $user->setRoles($request->roles);
        $user->setCreatedAt(new \DateTime());
        $user->setUpdatedAt(new \DateTime());

        $this->userRepository->save($user);
    }
}
