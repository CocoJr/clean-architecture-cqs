<?php

namespace Domain\Shared\Gateway;

interface MessageBusInterface
{
    public function send(object $message): mixed;
}
