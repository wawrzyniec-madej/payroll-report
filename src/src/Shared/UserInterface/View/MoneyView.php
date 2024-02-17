<?php

namespace App\Shared\UserInterface\View;

use App\Shared\Domain\ValueObject\Money;
use JsonSerializable;

final readonly class MoneyView implements JsonSerializable
{
    public function __construct(
        private Money $money
    ) {
    }

    /** @return array{amount: int, currency: string} */
    public function jsonSerialize(): array
    {
        return [
            'amount' => $this->money->getAmount(),
            'currency' => $this->money->getCurrency()->value
        ];
    }
}