<?php

namespace App\Shared\Infrastructure;

use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\Interface\AggregateEventDispatcherInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class SymfonyEventDispatcher implements AggregateEventDispatcherInterface
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function dispatch(AggregateRoot $aggregateRoot): void
    {
        foreach ($aggregateRoot->pullEvents() as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}