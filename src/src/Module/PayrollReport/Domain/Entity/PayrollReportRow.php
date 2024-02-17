<?php

namespace App\Module\PayrollReport\Domain\Entity;

use App\Module\PayrollReport\Domain\Interface\GetBonusDetailsInterface;
use App\Module\PayrollReport\Domain\ValueObject\BonusDetails;
use App\Module\PayrollReport\Domain\ValueObject\Employee;
use App\Shared\Domain\Interface\IdentifierGeneratorInterface;
use App\Shared\Domain\ValueObject\Identifier;

final class PayrollReportRow
{
    private function __construct(
        private Identifier $id,
        private Employee $employee,
        private BonusDetails $bonusDetails
    ) {
    }

    public static function create(
        IdentifierGeneratorInterface $identifierGenerator,
        Employee $employee,
        GetBonusDetailsInterface $getBonusDetails
    ): self {
        return new self(
            $identifierGenerator->generate(),
            $employee,
            $getBonusDetails->getForEmployee($employee)
        );
    }

    public function getId(): Identifier
    {
        return $this->id;
    }

    public function getBonusDetails(): BonusDetails
    {
        return $this->bonusDetails;
    }

    public function getEmployee(): Employee
    {
        return $this->employee;
    }
}