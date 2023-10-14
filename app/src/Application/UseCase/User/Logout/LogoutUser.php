<?php

namespace Application\UseCase\User\Logout;

use Application\Gateway\SecurityInterface;

final readonly class LogoutUser
{
    public function __construct(private SecurityInterface $security)
    {
    }

    public function __invoke(LogoutUserRequest $request): LogoutUserResponse
    {
        $this->security->logout();

        return new LogoutUserResponse();
    }
}
