<?php

namespace App\Module\Bonus\UserInterface\Adapter;

use App\Module\Bonus\Application\Query\GetBonusDetailsForEmployeeQuery;
use App\Module\Bonus\Domain\ValueObject\Employee;
use App\Module\Bonus\Domain\ValueObject\YearsOfSeniority;
use App\Shared\Domain\Enum\CurrencyEnum;
use App\Shared\Domain\ValueObject\Identifier;
use App\Shared\Domain\ValueObject\Money;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;

#[Autoconfigure(public: true)]
final class GetBonus
{
    public function __construct(
        private readonly GetBonusDetailsForEmployeeQuery $getBonusDetailsForEmployeeQuery
    ) {
    }

    public function get(): array
    {
        $data = $this->getBonusDetailsForEmployeeQuery->get(
            new Employee(
                new Money(1000, CurrencyEnum::USD),
                new YearsOfSeniority(5)
            ),
            new Identifier('01HPT130YC9KJPRVKGE1N2PNR2'),
        );

        return [];
    }
}