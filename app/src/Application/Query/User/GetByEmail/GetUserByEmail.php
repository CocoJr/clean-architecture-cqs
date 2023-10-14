<?php

namespace Application\Query\User\GetByEmail;

use Domain\User\Exception\UserNotExistsException;
use Domain\User\Query\GetByEmail\GetUserByEmailInterface;
use Domain\User\Query\GetByEmail\GetUserByEmailRequest;
use Domain\User\Query\GetByEmail\GetUserByEmailResponse;
use Domain\User\Repository\UserRepositoryInterface;

final readonly class GetUserByEmail implements GetUserByEmailInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetUserByEmailRequest $request): GetUserByEmailResponse
    {
        $user = $this->userRepository->getByEmail($request->email);

        if (!$user) {
            throw new UserNotExistsException();
        }

        return new GetUserByEmailResponse($user);
    }
}
