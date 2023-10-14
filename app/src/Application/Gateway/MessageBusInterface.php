<?php

namespace Application\Gateway;

interface MessageBusInterface
{
    public function send(object $message): mixed;
}
