<?php

namespace App\Shared\Domain;

use App\Shared\Domain\Interface\DomainEventInterface;

abstract class AggregateRoot
{
    private DomainEventCollection $events;

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
}