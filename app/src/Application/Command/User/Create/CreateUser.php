<?php

namespace Application\Command\User\Create;

use Domain\User\Command\Create\CreateUserInterface;
use Domain\User\Command\Create\CreateUserRequest;
use Domain\User\Entity\User;
use Domain\User\Repository\UserRepositoryInterface;

final readonly class CreateUser implements CreateUserInterface
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(CreateUserRequest $request): void
    {
        $user = new User();
        $user->setEmail($request->email);
        $user->setUsername($request->username);
        $user->setPassword($request->password);
        $user->setCreatedAt(new \DateTime());
        $user->setUpdatedAt(new \DateTime());

        $this->userRepository->save($user);
    }
}
