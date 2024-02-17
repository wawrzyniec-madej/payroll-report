<?php

namespace App\Tests\Functional\Unit\Bonus;

use App\Module\Bonus\Domain\Entity\PercentageBonus;
use App\Module\Bonus\Domain\Entity\SeniorityBonus;
use App\Module\Bonus\Domain\Enum\BonusTypeEnum;
use App\Module\Bonus\Domain\Interface\BonusInterface;
use App\Module\Bonus\Domain\ValueObject\BonusDetails;
use App\Module\Bonus\Domain\ValueObject\Employee;
use App\Module\Bonus\Domain\ValueObject\YearsOfSeniority;
use App\Shared\Domain\Enum\CurrencyEnum;
use App\Shared\Domain\ValueObject\Money;
use App\Shared\Domain\ValueObject\Percentage;
use App\Tests\Helper\IdentifierHelper;
use Generator;
use PHPUnit\Framework\TestCase;

final class BonusCalculatesSuccessfullyTest extends TestCase
{
    /** @dataProvider successfulDataProvider */
    public function test_calculates_successfully(
        BonusInterface $bonus,
        Employee $employee,
        BonusDetails $expectedDetails
    ): void {
        $details = $bonus->calculateForEmployee($employee);

        self::assertEquals(
            $expectedDetails->getSalaryWithBonus()->getAmount(),
            $details->getSalaryWithBonus()->getAmount()
        );

        self::assertEquals(
            $expectedDetails->getBonus()->getAmount(),
            $details->getBonus()->getAmount()
        );
    }

    private function successfulDataProvider(): Generator
    {
        $tenPercentBonus = new PercentageBonus(
            IdentifierHelper::generateUlid(),
            new Percentage(10)
        );

        $onePercentBonus = new PercentageBonus(
            IdentifierHelper::generateUlid(),
            new Percentage(1)
        );

        $irregularPercentBonus = new PercentageBonus(
            IdentifierHelper::generateUlid(),
            new Percentage(39)
        );

        $tenYearSeniorityBonus = new SeniorityBonus(
            IdentifierHelper::generateUlid(),
            new Money(10000, CurrencyEnum::USD),
            new YearsOfSeniority(10)
        );

        $threeYearSeniorityBonus = new SeniorityBonus(
            IdentifierHelper::generateUlid(),
            new Money(100000, CurrencyEnum::USD),
            new YearsOfSeniority(3)
        );

        yield [
            $irregularPercentBonus,
            new Employee(
                new Money(153321, CurrencyEnum::USD),
                new YearsOfSeniority(1)
            ),
            new BonusDetails(
                BonusTypeEnum::PERCENTAGE,
                new Money(59795, CurrencyEnum::USD),
                new Money(213116, CurrencyEnum::USD)
            )
        ];

        yield [
            $onePercentBonus,
            new Employee(
                new Money(100000, CurrencyEnum::USD),
                new YearsOfSeniority(30)
            ),
            new BonusDetails(
                BonusTypeEnum::PERCENTAGE,
                new Money(1000, CurrencyEnum::USD),
                new Money(101000, CurrencyEnum::USD)
            )
        ];

        yield [
            $tenPercentBonus,
            new Employee(
                new Money(1000, CurrencyEnum::USD),
                new YearsOfSeniority(5)
            ),
            new BonusDetails(
                BonusTypeEnum::PERCENTAGE,
                new Money(100, CurrencyEnum::USD),
                new Money(1100, CurrencyEnum::USD)
            )
        ];

        yield [
            $threeYearSeniorityBonus,
            new Employee(
                new Money(100000, CurrencyEnum::USD),
                new YearsOfSeniority(5)
            ),
            new BonusDetails(
                BonusTypeEnum::SENIORITY,
                new Money(300000, CurrencyEnum::USD),
                new Money(400000, CurrencyEnum::USD)
            )
        ];

        yield [
            $tenYearSeniorityBonus,
            new Employee(
                new Money(100000, CurrencyEnum::USD),
                new YearsOfSeniority(15)
            ),
            new BonusDetails(
                BonusTypeEnum::SENIORITY,
                new Money(100000, CurrencyEnum::USD),
                new Money(200000, CurrencyEnum::USD)
            )
        ];

        yield [
            $tenYearSeniorityBonus,
            new Employee(
                new Money(100000, CurrencyEnum::USD),
                new YearsOfSeniority(5)
            ),
            new BonusDetails(
                BonusTypeEnum::SENIORITY,
                new Money(50000, CurrencyEnum::USD),
                new Money(150000, CurrencyEnum::USD)
            )
        ];

        yield [
            $tenYearSeniorityBonus,
            new Employee(
                new Money(100000, CurrencyEnum::USD),
                new YearsOfSeniority(1)
            ),
            new BonusDetails(
                BonusTypeEnum::SENIORITY,
                new Money(10000, CurrencyEnum::USD),
                new Money(110000, CurrencyEnum::USD)
            )
        ];
    }
}