<?php

declare(strict_types=1);

namespace App\Tests\Functional\Unit\Bonus;

use App\Module\Bonus\Domain\Entity\SeniorityBonus;
use App\Module\Bonus\Domain\Interface\BonusInterface;
use App\Module\Bonus\Domain\ValueObject\YearsOfSeniority;
use App\Shared\Domain\Enum\CurrencyEnum;
use App\Shared\Domain\Exception\IncompatibleMoneyException;
use App\Shared\Domain\Money;
use App\Tests\Helper\IdentifierHelper;
use Generator;
use PHPUnit\Framework\TestCase;

final class BonusFailsWhenDifferentCurrenciesApplyTest extends TestCase
{
    /** @dataProvider dataProvider */
    public function testThrowsException(
        BonusInterface $bonus,
        Money $remunerationBase,
        YearsOfSeniority $yearsOfSeniority
    ): void {
        $this->expectException(IncompatibleMoneyException::class);

        $bonus->calculate(
            $remunerationBase,
            $yearsOfSeniority
        );
    }

    private function dataProvider(): Generator
    {
        yield [
            new SeniorityBonus(
                IdentifierHelper::generateUlid(),
                new Money(100000, CurrencyEnum::USD),
                new YearsOfSeniority(15),
            ),
            new Money(500000, CurrencyEnum::PLN),
            new YearsOfSeniority(20),
        ];

        yield [
            new SeniorityBonus(
                IdentifierHelper::generateUlid(),
                new Money(100000, CurrencyEnum::PLN),
                new YearsOfSeniority(15),
            ),
            new Money(500000, CurrencyEnum::USD),
            new YearsOfSeniority(20),
        ];
    }
}
