<?php

namespace Domain\User\Command\Create;

interface CreateUserInterface
{
    public function __invoke(CreateUserRequest $request): void;
}
