<?php

declare(strict_types=1);

namespace App\Shared\Domain\Interface;

interface DomainEventInterface
{
    public function getOccurredAt(): \DateTimeImmutable;
}
