<?php

namespace App\Module\PayrollReport\Domain\ValueObject;

use App\Module\PayrollReport\Domain\Interface\BonusInterface;

final readonly class Department
{
    public function __construct(
        private DepartmentName $name,
        private BonusInterface $bonus
    ) {
    }

    public function getName(): DepartmentName
    {
        return $this->name;
    }

    public function getBonus(): BonusInterface
    {
        return $this->bonus;
    }
}