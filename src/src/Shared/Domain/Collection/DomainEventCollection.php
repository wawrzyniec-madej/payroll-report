<?php

declare(strict_types=1);

namespace App\Shared\Domain\Collection;

use App\Shared\Components\TypedCollection;
use App\Shared\Domain\Interface\DomainEventInterface;

/** @extends TypedCollection<DomainEventInterface> */
final class DomainEventCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return DomainEventInterface::class;
    }
}
