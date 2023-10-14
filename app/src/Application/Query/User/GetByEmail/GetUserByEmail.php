<?php

namespace Application\Query\User\GetByEmail;

use Domain\User\Error\UserNotExistsException;
use Domain\User\Repository\UserRepositoryInterface;

final readonly class GetUserByEmail
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetUserByEmailRequest $request): GetUserByEmailResponse
    {
        $user = $this->userRepository->getByEmail($request->email->getValue());

        if (!$user) {
            throw new UserNotExistsException();
        }

        return new GetUserByEmailResponse($user);
    }
}
