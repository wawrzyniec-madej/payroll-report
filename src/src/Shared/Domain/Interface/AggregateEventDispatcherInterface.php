<?php

declare(strict_types=1);

namespace App\Shared\Domain\Interface;

use App\Shared\Domain\AggregateRoot;

interface AggregateEventDispatcherInterface
{
    public function dispatch(AggregateRoot $aggregateRoot): void;
}
