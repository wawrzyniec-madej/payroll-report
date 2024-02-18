<?php

declare(strict_types=1);

namespace App\Module\Bonus\Domain\Interface;

use App\Module\Bonus\Domain\ValueObject\BonusDetails;
use App\Module\Bonus\Domain\ValueObject\YearsOfSeniority;
use App\Shared\Domain\Money;

interface BonusInterface
{
    public function calculate(Money $remunerationBase, YearsOfSeniority $yearsOfSeniority): BonusDetails;
}
