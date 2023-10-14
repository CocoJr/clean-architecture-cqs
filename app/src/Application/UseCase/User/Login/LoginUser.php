<?php

namespace Application\UseCase\User\Login;

use Application\Gateway\SecurityInterface;
use Application\Gateway\User\UserQueryBus;
use Application\Query\User\GetByEmail\GetUserByEmailRequest;
use Domain\User\Error\UserLoginFailedException;
use Domain\User\Model\User;

final readonly class LoginUser
{
    public function __construct(private UserQueryBus $userQueryBus, private SecurityInterface $security)
    {
    }

    public function __invoke(LoginUserRequest $request): LoginUserResponse
    {
        $getUserByEmailResponse = $this->userQueryBus->getByEmail(
            new GetUserByEmailRequest($request->email)
        );

        $user = $getUserByEmailResponse->user;

        if (!User::checkPassword($request->password->getValue(), $user->getPassword())) {
            throw new UserLoginFailedException();
        }

        $this->security->login($user);

        return new LoginUserResponse($user);
    }
}
