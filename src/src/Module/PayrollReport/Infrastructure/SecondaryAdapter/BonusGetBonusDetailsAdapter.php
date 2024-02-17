<?php

namespace App\Module\PayrollReport\Infrastructure\SecondaryAdapter;

use App\Module\Bonus\UserInterface\PrimaryAdapter\GetBonusDetailsForEmployee;
use App\Module\PayrollReport\Domain\Interface\GetBonusDetailsInterface;
use App\Module\PayrollReport\Domain\ValueObject\BonusDetails;
use App\Module\PayrollReport\Domain\ValueObject\BonusName;
use App\Module\PayrollReport\Domain\ValueObject\Employee;
use App\Shared\Domain\Enum\CurrencyEnum;
use App\Shared\Domain\ValueObject\Identifier;
use App\Shared\Domain\ValueObject\Money;

final readonly class BonusGetBonusDetailsAdapter implements GetBonusDetailsInterface
{
    public function __construct(
        private GetBonusDetailsForEmployee $getBonusDetailsForEmployee
    ) {
    }

    public function getForEmployee(Employee $employee): BonusDetails
    {
        $result = $this->getBonusDetailsForEmployee->get(
            [
                'amount' => $employee->getRemunerationBase()->getAmount(),
                'currency' => $employee->getRemunerationBase()->getCurrency()->value
            ],
            $employee->getYearsOfSeniority()->getValue(),
            $employee->getDepartment()->getBonusId()->getValue()
        );

        return new BonusDetails(
            new BonusName($result['name']),
            new Money(
                $result['bonus']['amount'],
                CurrencyEnum::from($result['bonus']['currency'])
            ),
            new Money(
                $result['salaryWithBonus']['amount'],
                CurrencyEnum::from(($result['salaryWithBonus']['currency']))
            )
        );
    }
}