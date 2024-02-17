<?php

namespace App\Shared\Domain;

use App\Shared\Domain\Enum\CurrencyEnum;
use App\Shared\Domain\Exception\IncompatibleMoneyException;
use App\Shared\Domain\ValueObject\Percentage;

final readonly class Money
{
    public function __construct(
        private int $amount,
        private CurrencyEnum $currency
    ) {
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): CurrencyEnum
    {
        return $this->currency;
    }

    public function multiplyByPercentage(Percentage $percentage): self
    {
        return new Money(
            (int) floor($this->amount * $percentage->getFloat()),
            $this->currency
        );
    }

    public function multiply(int $times): self
    {
        return new Money(
            $this->amount * $times,
            $this->currency
        );
    }

    /** @throws IncompatibleMoneyException */
    public function add(Money $money): self
    {
        if (!$this->currency->isEqual($money->currency)) {
            throw IncompatibleMoneyException::create($money->currency, $this->currency);
        }

        return new Money(
            $this->amount + $money->amount,
            $this->currency
        );
    }
}
