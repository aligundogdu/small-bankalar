<?php

namespace Common\Infrastructure\MessageBus;

use Common\Domain\Bus\AsyncMessage;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerBus
{
    use HandleTrait {
        handle as handleCommand;
    }


    public function __construct(private readonly  MessageBusInterface $bus)
    {
    }

    public function dispatch(AsyncMessage $message): void
    {
        $this->bus->dispatch($message);
    }
}
