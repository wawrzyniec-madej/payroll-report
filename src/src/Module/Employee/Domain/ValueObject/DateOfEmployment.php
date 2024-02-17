<?php

namespace App\Module\Employee\Domain\ValueObject;

use DateTimeImmutable;

final class DateOfEmployment
{
    public function __construct(
        private readonly DateTimeImmutable $value
    ) {
    }

    public function getValue(): DateTimeImmutable
    {
        return $this->value;
    }
}