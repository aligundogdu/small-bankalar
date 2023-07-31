<?php

namespace Common\Infrastructure\MessageBus;

use Common\Domain\Bus\Query\Query;
use Common\Domain\Bus\Query\QueryBus;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerQueryBus implements QueryBus
{
    use HandleTrait {
        handle as handleQuery;
    }

    public function __construct(private readonly MessageBusInterface $queryBus)
    {
        $this->messageBus = $this->queryBus;
    }

    public function handle(Query $query): mixed
    {
        return $this->handleQuery($query);
    }
}
