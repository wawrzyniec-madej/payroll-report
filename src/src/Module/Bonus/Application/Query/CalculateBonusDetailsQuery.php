<?php

declare(strict_types=1);

namespace App\Module\Bonus\Application\Query;

use App\Module\Bonus\Domain\Exception\BonusNotFoundException;
use App\Module\Bonus\Domain\Exception\InvalidPercentageException;
use App\Module\Bonus\Domain\Exception\InvalidYearsOfSeniorityException;
use App\Module\Bonus\Domain\Exception\UnsupportedBonusTypeException;
use App\Module\Bonus\Domain\Interface\BonusRepositoryInterface;
use App\Module\Bonus\Domain\ValueObject\BonusDetails;
use App\Module\Bonus\Domain\ValueObject\YearsOfSeniority;
use App\Shared\Domain\Exception\IncompatibleMoneyException;
use App\Shared\Domain\Money;
use App\Shared\Domain\ValueObject\Identifier;

final readonly class CalculateBonusDetailsQuery
{
    public function __construct(
        private BonusRepositoryInterface $bonusRepository
    ) {
    }

    /**
     * @throws BonusNotFoundException
     * @throws InvalidYearsOfSeniorityException
     * @throws UnsupportedBonusTypeException
     * @throws InvalidPercentageException
     * @throws IncompatibleMoneyException
     */
    public function calculate(Money $remunerationBase, YearsOfSeniority $yearsOfSeniority, Identifier $bonusId): BonusDetails
    {
        $bonus = $this->bonusRepository->getOneById($bonusId);

        return $bonus->calculate($remunerationBase, $yearsOfSeniority);
    }
}
