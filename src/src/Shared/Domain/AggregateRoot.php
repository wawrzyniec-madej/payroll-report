<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use App\Shared\Domain\Collection\DomainEventCollection;
use App\Shared\Domain\Interface\AggregateEventDispatcherInterface;
use App\Shared\Domain\Interface\DomainEventInterface;
use App\Shared\Domain\Interface\TransactionInterface;

abstract class AggregateRoot
{
    private DomainEventCollection $events;

    /** @var TransactionInterface<static> */
    private TransactionInterface $transaction;
    private AggregateEventDispatcherInterface $aggregateEventDispatcher;

    public function pullEvents(): DomainEventCollection
    {
        $events = $this->getEvents();

        $this->events = DomainEventCollection::createEmpty();

        return $events;
    }

    public function addEvent(DomainEventInterface $domainEvent): void
    {
        $this->getEvents()->add($domainEvent);
    }

    private function getEvents(): DomainEventCollection
    {
        if (!isset($this->events)) {
            $this->events = DomainEventCollection::createEmpty();
        }

        return $this->events;
    }

    public function getEventDispatcher(): AggregateEventDispatcherInterface
    {
        return $this->aggregateEventDispatcher;
    }

    /** @return TransactionInterface<static> */
    public function getTransaction(): TransactionInterface
    {
        return $this->transaction;
    }

    public function setTransaction(TransactionInterface $transaction): static
    {
        $this->transaction = $transaction;

        return $this;
    }

    public function setEventDispatcher(AggregateEventDispatcherInterface $aggregateEventDispatcher): static
    {
        $this->aggregateEventDispatcher = $aggregateEventDispatcher;

        return $this;
    }
}
