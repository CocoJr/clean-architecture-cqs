<?php

namespace Domain\User\Query\GetByEmail;

interface GetUserByEmailInterface
{
    public function __invoke(GetUserByEmailRequest $request): GetUserByEmailResponse;
}
