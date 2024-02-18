<?php

declare(strict_types=1);

namespace App\Shared\Domain\Collection;

use App\Shared\Domain\Interface\DomainEventInterface;
use App\Shared\TypedCollection;

/** @extends TypedCollection<DomainEventInterface> */
final class DomainEventCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return DomainEventInterface::class;
    }
}
