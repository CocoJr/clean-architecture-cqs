<?php

namespace Application\Gateway\User;

use Application\Gateway\AbstractMessageBus;
use Application\Query\User\GetByEmail\GetUserByEmailRequest;
use Application\Query\User\GetByEmail\GetUserByEmailResponse;

final class UserQueryBus extends AbstractMessageBus
{
    public function getByEmail(GetUserByEmailRequest $request): GetUserByEmailResponse
    {
        return $this->messageBus->send($request);
    }
}
