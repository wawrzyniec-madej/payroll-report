<?php

namespace App\Module\Bonus\Application\Query;

use App\Module\Bonus\Domain\Exception\BonusNotFoundException;
use App\Module\Bonus\Domain\Exception\InvalidYearsOfSeniorityException;
use App\Module\Bonus\Domain\Exception\UnsupportedBonusTypeException;
use App\Module\Bonus\Domain\Interface\BonusRepositoryInterface;
use App\Module\Bonus\Domain\ValueObject\BonusDetails;
use App\Module\Bonus\Domain\ValueObject\Employee;
use App\Shared\Domain\ValueObject\Identifier;

final readonly class GetBonusDetailsForEmployeeQuery
{
    public function __construct(
        private BonusRepositoryInterface $bonusRepository
    ) {
    }

    /**
     * @throws BonusNotFoundException
     * @throws InvalidYearsOfSeniorityException
     * @throws UnsupportedBonusTypeException
     */
    public function get(Employee $employee, Identifier $bonusId): BonusDetails
    {
        $bonus = $this->bonusRepository->getOneById($bonusId);

        return $bonus->calculateForEmployee($employee);
    }
}
