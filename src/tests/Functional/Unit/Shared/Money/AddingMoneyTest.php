<?php

namespace App\Tests\Functional\Unit\Shared\Money;

use App\Shared\Domain\Enum\CurrencyEnum;
use App\Shared\Domain\Exception\IncompatibleMoneyException;
use App\Shared\Domain\ValueObject\Money;
use PHPUnit\Framework\TestCase;

final class AddingMoneyTest extends TestCase
{
    public function testThrowsExceptionOnIncompatibleCurrencies(): void
    {
        self::expectException(IncompatibleMoneyException::class);

        $pln = new Money(1000, CurrencyEnum::PLN);
        $usd = new Money(1000, CurrencyEnum::USD);

        $pln->add($usd);
    }

    public function testSuccess(): void
    {
        $firstPln = new Money(1000, CurrencyEnum::PLN);
        $secondPln = new Money(1000, CurrencyEnum::PLN);

        $addedMoney = $firstPln->add($secondPln);

        self::assertEquals(2000, $addedMoney->getAmount());
    }
}
