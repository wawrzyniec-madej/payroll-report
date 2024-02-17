<?php

namespace App\Shared\Domain\ValueObject;

use App\Shared\Domain\Enum\CurrencyEnum;
use App\Shared\Domain\Exception\IncompatibleMoneyException;

final class Money
{
    public function __construct(
        private readonly int $amount,
        private readonly CurrencyEnum $currency
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

    public function isEqual(self $compared): bool
    {
        return $this->amount === $compared->amount
            && $this->currency->isEqual($compared->currency);
    }
}
