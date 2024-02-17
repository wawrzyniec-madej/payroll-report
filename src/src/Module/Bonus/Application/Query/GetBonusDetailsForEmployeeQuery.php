<?php

namespace App\Module\Bonus\Application\Query;

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

    public function get(Employee $employee, Identifier $bonusId): BonusDetails
    {
        $bonus = $this->bonusRepository->getOneById($bonusId);

        return $bonus->calculateForEmployee($employee);
    }
}
