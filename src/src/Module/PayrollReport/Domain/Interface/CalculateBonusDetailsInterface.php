<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Domain\Interface;

use App\Module\PayrollReport\Domain\Exception\CannotCalculateBonusDetailsException;
use App\Module\PayrollReport\Domain\Exception\InvalidYearsOfSeniorityException;
use App\Module\PayrollReport\Domain\ValueObject\BonusDetails;
use App\Module\PayrollReport\Domain\ValueObject\YearsOfSeniority;
use App\Shared\Domain\Exception\IncompatibleMoneyException;
use App\Shared\Domain\Money;
use App\Shared\Domain\ValueObject\Identifier;

interface CalculateBonusDetailsInterface
{
    /**
     * @throws InvalidYearsOfSeniorityException
     * @throws IncompatibleMoneyException
     * @throws CannotCalculateBonusDetailsException
     */
    public function calculate(Money $remunerationBase, YearsOfSeniority $yearsOfSeniority, Identifier $bonusId): BonusDetails;
}
