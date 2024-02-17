<?php

namespace App\Module\Bonus\UserInterface\PrimaryAdapter;

use App\Module\Bonus\Application\Query\GetBonusDetailsForEmployeeQuery;
use App\Module\Bonus\Domain\Exception\BonusNotFoundException;
use App\Module\Bonus\Domain\Exception\InvalidYearsOfSeniorityException;
use App\Module\Bonus\Domain\Exception\UnsupportedBonusTypeException;
use App\Module\Bonus\Domain\ValueObject\Employee;
use App\Module\Bonus\Domain\ValueObject\YearsOfSeniority;
use App\Shared\Domain\Enum\CurrencyEnum;
use App\Shared\Domain\ValueObject\Identifier;
use App\Shared\Domain\ValueObject\Money;

final readonly class GetBonusDetailsForEmployee
{
    public function __construct(
        private GetBonusDetailsForEmployeeQuery $getBonusDetailsForEmployeeQuery
    ) {
    }

    /**
     * @param array{amount: int, currency: string} $baseSalary
     * @return array{name: string, bonus: array{amount: int, currency: string}}
     * @throws BonusNotFoundException
     * @throws InvalidYearsOfSeniorityException
     * @throws UnsupportedBonusTypeException
     */
    public function get(array $baseSalary, int $yearsOfSeniority, string $bonusId): array
    {
        $bonusDetails = $this->getBonusDetailsForEmployeeQuery->get(
            new Employee(
                new Money($baseSalary['amount'], CurrencyEnum::from($baseSalary['currency'])),
                new YearsOfSeniority($yearsOfSeniority)
            ),
            new Identifier($bonusId),
        );

        return [
            'name' => $bonusDetails->getType()->value,
            'bonus' => [
                'amount' => $bonusDetails->getBonus()->getAmount(),
                'currency' => $bonusDetails->getBonus()->getCurrency()->value,
            ],
        ];
    }
}
