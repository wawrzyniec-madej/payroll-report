<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Domain\ValueObject;

use App\Shared\Domain\Exception\IncompatibleMoneyException;
use App\Shared\Domain\Money;

final readonly class BonusDetails
{
    private function __construct(
        private BonusName $name,
        private Money $additionToBase,
        private Money $salaryWithBonus
    ) {
    }

    /** @throws IncompatibleMoneyException */
    public static function create(
        BonusName $bonusName,
        Money $additionToBase,
        Money $remunerationBase
    ): self {
        return new self(
            $bonusName,
            $additionToBase,
            $remunerationBase->add($additionToBase)
        );
    }

    public function getSalaryWithBonus(): Money
    {
        return $this->salaryWithBonus;
    }

    public function getAdditionToBase(): Money
    {
        return $this->additionToBase;
    }

    public function getName(): BonusName
    {
        return $this->name;
    }
}
