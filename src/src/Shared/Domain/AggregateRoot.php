<?php

namespace App\Shared\Domain;

abstract class AggregateRoot
{
    private DomainEventCollection $events;

    protected function __construct()
    {
        $this->events = DomainEventCollection::createEmpty();
    }

    public function pullEvents(): DomainEventCollection
    {
        $events = $this->events;

        $this->events = DomainEventCollection::createEmpty();

        return $events;
    }

    public function addEvent(DomainEvent $domainEvent): void
    {
        $this->events = $this->events->add($domainEvent);
    }
}