<?php

namespace Domain\User\UseCase\Login;

use Domain\Shared\Gateway\MessageBusInterface;
use Domain\Shared\Gateway\SecurityInterface;
use Domain\User\Exception\UserLoginFailedException;
use Domain\User\Query\GetByEmail\GetUserByEmailRequest;

final readonly class LoginUser
{
    public function __construct(private MessageBusInterface $messageBus, private SecurityInterface $security)
    {
    }

    public function __invoke(LoginUserRequest $request): LoginUserResponse
    {
        $getUserByEmailResponse = $this->messageBus->send(
            new GetUserByEmailRequest($request->email)
        );

        $user = $getUserByEmailResponse->user;

        if (!$user->checkPassword($request->password)) {
            throw new UserLoginFailedException();
        }

        $this->security->login($user);

        return new LoginUserResponse($user);
    }
}
