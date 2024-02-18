<?php

declare(strict_types=1);

namespace App\Tests\Functional\Unit\Bonus;

use App\Module\Bonus\Domain\Entity\PercentageBonus;
use App\Module\Bonus\Domain\Entity\SeniorityBonus;
use App\Module\Bonus\Domain\Enum\BonusTypeEnum;
use App\Module\Bonus\Domain\Interface\BonusInterface;
use App\Module\Bonus\Domain\ValueObject\BonusDetails;
use App\Module\Bonus\Domain\ValueObject\Percentage;
use App\Module\Bonus\Domain\ValueObject\YearsOfSeniority;
use App\Shared\Domain\Enum\CurrencyEnum;
use App\Shared\Domain\Money;
use App\Tests\Helper\IdentifierHelper;
use Generator;
use PHPUnit\Framework\TestCase;

final class BonusCalculatesSuccessfullyTest extends TestCase
{
    /** @dataProvider successfulDataProvider */
    public function testCalculatesSuccessfully(
        BonusInterface $bonus,
        Money $remunerationBase,
        YearsOfSeniority $yearsOfSeniority,
        BonusDetails $expectedDetails
    ): void {
        $details = $bonus->calculate(
            $remunerationBase,
            $yearsOfSeniority
        );

        self::assertEquals(
            $expectedDetails->getBonus()->getAmount(),
            $details->getBonus()->getAmount()
        );

        self::assertEquals(
            $expectedDetails->getType()->value,
            $details->getType()->value
        );
    }

    private function successfulDataProvider(): Generator
    {
        yield [
            new PercentageBonus(
                IdentifierHelper::generateUlid(),
                new Percentage(39)
            ),
            new Money(153321, CurrencyEnum::USD),
            new YearsOfSeniority(1),
            new BonusDetails(
                BonusTypeEnum::PERCENTAGE,
                new Money(59795, CurrencyEnum::USD),
            ),
        ];

        yield [
            new PercentageBonus(
                IdentifierHelper::generateUlid(),
                new Percentage(1)
            ),
            new Money(100000, CurrencyEnum::USD),
            new YearsOfSeniority(30),
            new BonusDetails(
                BonusTypeEnum::PERCENTAGE,
                new Money(1000, CurrencyEnum::USD),
            ),
        ];

        yield [
            new PercentageBonus(
                IdentifierHelper::generateUlid(),
                new Percentage(10)
            ),
            new Money(1000, CurrencyEnum::USD),
            new YearsOfSeniority(5),
            new BonusDetails(
                BonusTypeEnum::PERCENTAGE,
                new Money(100, CurrencyEnum::USD),
            ),
        ];

        yield [
            new SeniorityBonus(
                IdentifierHelper::generateUlid(),
                new Money(100000, CurrencyEnum::USD),
                new YearsOfSeniority(3)
            ),
            new Money(100000, CurrencyEnum::USD),
            new YearsOfSeniority(5),
            new BonusDetails(
                BonusTypeEnum::SENIORITY,
                new Money(300000, CurrencyEnum::USD),
            ),
        ];

        yield [
            new SeniorityBonus(
                IdentifierHelper::generateUlid(),
                new Money(10000, CurrencyEnum::PLN),
                new YearsOfSeniority(10)
            ),
            new Money(100000, CurrencyEnum::PLN),
            new YearsOfSeniority(15),
            new BonusDetails(
                BonusTypeEnum::SENIORITY,
                new Money(100000, CurrencyEnum::PLN),
            ),
        ];

        yield [
            new SeniorityBonus(
                IdentifierHelper::generateUlid(),
                new Money(5000, CurrencyEnum::USD),
                new YearsOfSeniority(10)
            ),
            new Money(100000, CurrencyEnum::USD),
            new YearsOfSeniority(5),
            new BonusDetails(
                BonusTypeEnum::SENIORITY,
                new Money(25000, CurrencyEnum::USD),
            ),
        ];

        yield [
            new SeniorityBonus(
                IdentifierHelper::generateUlid(),
                new Money(5000, CurrencyEnum::USD),
                new YearsOfSeniority(10)
            ),
            new Money(100000, CurrencyEnum::USD),
            new YearsOfSeniority(2),
            new BonusDetails(
                BonusTypeEnum::SENIORITY,
                new Money(10000, CurrencyEnum::USD),
            ),
        ];

        yield [
            new SeniorityBonus(
                IdentifierHelper::generateUlid(),
                new Money(100000, CurrencyEnum::PLN),
                new YearsOfSeniority(15),
            ),
            new Money(500000, CurrencyEnum::PLN),
            new YearsOfSeniority(20),
            new BonusDetails(
                BonusTypeEnum::SENIORITY,
                new Money(1500000, CurrencyEnum::PLN),
            ),
        ];
    }
}
