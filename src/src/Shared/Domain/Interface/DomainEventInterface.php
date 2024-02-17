<?php

namespace App\Shared\Domain\Interface;

use DateTimeImmutable;

interface DomainEventInterface
{
    public function getOccurredAt(): DateTimeImmutable;
}