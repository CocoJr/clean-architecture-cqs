<?php

namespace Domain\User\UseCase\Register;

use Domain\Shared\Gateway\MessageBusInterface;
use Domain\User\Command\Create\CreateUserRequest;
use Domain\User\Exception\UserAlreadyExistsException;
use Domain\User\Exception\UserNotExistsException;
use Domain\User\Query\GetByEmail\GetUserByEmailRequest;

final readonly class RegisterUser
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function __invoke(RegisterUserRequest $request): void
    {
        try {
            $user = $this->messageBus->send(
                new GetUserByEmailRequest($request->email)
            );
            if ($user) {
                throw new UserAlreadyExistsException();
            }
        } catch (UserNotExistsException $e) {
        }

        $this->messageBus->send(
            new CreateUserRequest($request->username, $request->email, $request->password)
        );
    }
}
