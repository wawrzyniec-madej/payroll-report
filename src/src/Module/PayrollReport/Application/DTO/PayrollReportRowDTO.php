<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Application\DTO;

final readonly class PayrollReportRowDTO
{
    public function __construct(
        private string $name,
        private string $surname,
        private string $department,
        private int $remunerationBase,
        private int $additionToBase,
        private string $bonusType,
        private int $salaryWithBonus,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getDepartment(): string
    {
        return $this->department;
    }

    public function getRemunerationBase(): int
    {
        return $this->remunerationBase;
    }

    public function getAdditionToBase(): int
    {
        return $this->additionToBase;
    }

    public function getBonusType(): string
    {
        return $this->bonusType;
    }

    public function getSalaryWithBonus(): int
    {
        return $this->salaryWithBonus;
    }
}
