<?php

namespace Application\UseCase\User\Register;

use Application\Command\User\Create\CreateUserRequest;
use Application\Gateway\User\UserCommandBus;
use Application\Gateway\User\UserQueryBus;
use Application\Query\User\GetByEmail\GetUserByEmailRequest;
use Domain\User\Error\UserAlreadyExistsException;
use Domain\User\Error\UserNotExistsException;
use Domain\User\Value\Role;
use Domain\User\Value\Roles;

final readonly class RegisterUser
{
    public function __construct(
        private UserQueryBus $userQueryBus,
        private UserCommandBus $userCommandBus,
    ) {
    }

    public function __invoke(RegisterUserRequest $request): void
    {
        try {
            $this->userQueryBus->getByEmail(
                new GetUserByEmailRequest($request->email)
            );

            throw new UserAlreadyExistsException();
        } catch (UserNotExistsException $e) {
        }

        $this->userCommandBus->create(
            new CreateUserRequest(
                $request->username,
                $request->email,
                $request->password,
                new Roles(new Role('ROLE_USER')),
            )
        );
    }
}
