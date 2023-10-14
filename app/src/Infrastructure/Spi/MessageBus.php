<?php

namespace Infrastructure\Spi;

use Application\Gateway\MessageBusInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface as SymfonyMessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final readonly class MessageBus implements MessageBusInterface
{
    public function __construct(private SymfonyMessageBusInterface $bus)
    {
    }

    public function send(object $message): mixed
    {
        try {
            $envelope = $this->bus->dispatch($message);
        } catch (HandlerFailedException $e) {
            throw $e->getPrevious();
        }

        $handledStamp = $envelope->last(HandledStamp::class);

        return $handledStamp->getResult();
    }
}
