<?php

namespace App\Shared\Domain\Interface;

use App\Shared\Domain\AggregateRoot;

interface AggregateEventDispatcherInterface
{
    public function dispatch(AggregateRoot $aggregateRoot): void;
}