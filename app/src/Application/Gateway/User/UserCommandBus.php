<?php

namespace Application\Gateway\User;

use Application\Command\User\Create\CreateUserRequest;
use Application\Gateway\AbstractMessageBus;

final class UserCommandBus extends AbstractMessageBus
{
    public function create(CreateUserRequest $request): void
    {
        $this->messageBus->send($request);
    }
}
