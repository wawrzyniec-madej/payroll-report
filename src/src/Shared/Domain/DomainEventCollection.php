<?php

namespace App\Shared\Domain;

use App\Shared\Domain\Interface\DomainEventInterface;

/** @extends TypedCollection<DomainEventInterface> */
final class DomainEventCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return DomainEventInterface::class;
    }
}