<?php

namespace Application\Gateway\User;

use Application\Gateway\AbstractMessageBus;
use Application\UseCase\User\GetLogged\GetLoggedUserRequest;
use Application\UseCase\User\GetLogged\GetLoggedUserResponse;
use Application\UseCase\User\Login\LoginUserRequest;
use Application\UseCase\User\Login\LoginUserResponse;
use Application\UseCase\User\Logout\LogoutUserRequest;
use Application\UseCase\User\Logout\LogoutUserResponse;
use Application\UseCase\User\Register\RegisterUserRequest;

final class UserUseCaseBus extends AbstractMessageBus
{
    public function getLogged(GetLoggedUserRequest $request): GetLoggedUserResponse
    {
        return $this->messageBus->send($request);
    }

    public function login(LoginUserRequest $request): LoginUserResponse
    {
        return $this->messageBus->send($request);
    }

    public function logout(LogoutUserRequest $request): LogoutUserResponse
    {
        return $this->messageBus->send($request);
    }

    public function register(RegisterUserRequest $request): void
    {
        $this->messageBus->send($request);
    }
}
