<?php

namespace App\Module\PayrollReport\Domain\ValueObject;

final readonly class BonusDetails
{
    public function __construct(
        private AdditionToBase $additionToBase,
        private SalaryWithBonus $salaryWithBonus
    ) {
    }

    public function getSalaryWithBonus(): SalaryWithBonus
    {
        return $this->salaryWithBonus;
    }

    public function getAdditionToBase(): AdditionToBase
    {
        return $this->additionToBase;
    }
}