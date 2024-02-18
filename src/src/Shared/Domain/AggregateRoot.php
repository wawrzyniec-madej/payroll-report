<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use App\Shared\Domain\Collection\DomainEventCollection;
use App\Shared\Domain\Exception\CollectionElementInvalidException;
use App\Shared\Domain\Interface\DomainEventInterface;

abstract class AggregateRoot
{
    private DomainEventCollection $events;

    /** @throws CollectionElementInvalidException */
    public function pullEvents(): DomainEventCollection
    {
        $events = $this->getEvents();

        $this->events = DomainEventCollection::createEmpty();

        return $events;
    }

    /** @throws CollectionElementInvalidException */
    public function addEvent(DomainEventInterface $domainEvent): void
    {
        $this->getEvents()->add($domainEvent);
    }

    /** @throws CollectionElementInvalidException */
    private function getEvents(): DomainEventCollection
    {
        if (!isset($this->events)) {
            $this->events = DomainEventCollection::createEmpty();
        }

        return $this->events;
    }
}
