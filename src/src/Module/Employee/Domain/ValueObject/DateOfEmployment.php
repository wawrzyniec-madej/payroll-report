<?php

namespace App\Module\Employee\Domain\ValueObject;

use DateTimeImmutable;

final readonly class DateOfEmployment
{
    public function __construct(
        private DateTimeImmutable $value
    ) {
    }

    public function getValue(): DateTimeImmutable
    {
        return $this->value;
    }
}
