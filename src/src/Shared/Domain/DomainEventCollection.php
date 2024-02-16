<?php

namespace App\Shared\Domain;

/** @extends TypedCollection<DomainEventInterface> */
final class DomainEventCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return DomainEventInterface::class;
    }
}