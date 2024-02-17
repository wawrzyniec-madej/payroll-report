<?php

namespace App\Shared\Domain\Interface;

interface DomainEventInterface
{
    public function getOccurredAt(): \DateTimeImmutable;
}
