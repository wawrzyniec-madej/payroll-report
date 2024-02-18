<?php

declare(strict_types=1);

namespace App\Module\Bonus\UserInterface\PrimaryAdapter;

use App\Module\Bonus\Application\Query\CalculateBonusDetailsQuery;
use App\Module\Bonus\Domain\Exception\BonusNotFoundException;
use App\Module\Bonus\Domain\Exception\InvalidPercentageException;
use App\Module\Bonus\Domain\Exception\InvalidYearsOfSeniorityException;
use App\Module\Bonus\Domain\Exception\UnsupportedBonusTypeException;
use App\Module\Bonus\Domain\ValueObject\YearsOfSeniority;
use App\Shared\Domain\Enum\CurrencyEnum;
use App\Shared\Domain\Exception\IncompatibleMoneyException;
use App\Shared\Domain\Money;
use App\Shared\Domain\ValueObject\Identifier;

final readonly class CalculateBonusDetailsAdapter
{
    public function __construct(
        private CalculateBonusDetailsQuery $getBonusDetailsForEmployeeQuery
    ) {
    }

    /**
     * @param array{amount: int, currency: string} $remunerationBase
     *
     * @return array{name: string, bonus: array{amount: int, currency: string}}
     *
     * @throws BonusNotFoundException
     * @throws InvalidYearsOfSeniorityException
     * @throws UnsupportedBonusTypeException
     * @throws InvalidPercentageException
     * @throws IncompatibleMoneyException
     */
    public function get(array $remunerationBase, int $yearsOfSeniority, string $bonusId): array
    {
        $bonusDetails = $this->getBonusDetailsForEmployeeQuery->calculate(
            new Money($remunerationBase['amount'], CurrencyEnum::from($remunerationBase['currency'])),
            new YearsOfSeniority($yearsOfSeniority),
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
