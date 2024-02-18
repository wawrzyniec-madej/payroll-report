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
            new Money(153321, CurrencyEnum::USD),
            new YearsOfSeniority(1),
            new BonusDetails(
                BonusTypeEnum::PERCENTAGE,
                new Money(59795, CurrencyEnum::USD),
            ),
        ];

        yield [
            $onePercentBonus,
            new Money(100000, CurrencyEnum::USD),
            new YearsOfSeniority(30),
            new BonusDetails(
                BonusTypeEnum::PERCENTAGE,
                new Money(1000, CurrencyEnum::USD),
            ),
        ];

        yield [
            $tenPercentBonus,
            new Money(1000, CurrencyEnum::USD),
            new YearsOfSeniority(5),
            new BonusDetails(
                BonusTypeEnum::PERCENTAGE,
                new Money(100, CurrencyEnum::USD),
            ),
        ];

        yield [
            $threeYearSeniorityBonus,
            new Money(100000, CurrencyEnum::USD),
            new YearsOfSeniority(5),
            new BonusDetails(
                BonusTypeEnum::SENIORITY,
                new Money(300000, CurrencyEnum::USD),
            ),
        ];

        yield [
            $tenYearSeniorityBonus,
            new Money(100000, CurrencyEnum::USD),
            new YearsOfSeniority(15),
            new BonusDetails(
                BonusTypeEnum::SENIORITY,
                new Money(100000, CurrencyEnum::USD),
            ),
        ];

        yield [
            $tenYearSeniorityBonus,
            new Money(100000, CurrencyEnum::USD),
            new YearsOfSeniority(5),
            new BonusDetails(
                BonusTypeEnum::SENIORITY,
                new Money(50000, CurrencyEnum::USD),
            ),
        ];

        yield [
            $tenYearSeniorityBonus,
            new Money(100000, CurrencyEnum::USD),
            new YearsOfSeniority(1),
            new BonusDetails(
                BonusTypeEnum::SENIORITY,
                new Money(10000, CurrencyEnum::USD),
            ),
        ];
    }
}
