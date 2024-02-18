<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\UserInterface\View;

use App\Module\PayrollReport\Application\DTO\PayrollReportRowDTO;

final readonly class PayrollReportRowView implements \JsonSerializable
{
    public function __construct(
        private PayrollReportRowDTO $payrollReportRowDTO
    ) {
    }

    /** @return array{name:string, surname:string, department:string, bonusType:string, remunerationBase:int, additionToBase:int, salaryWithBonus:int} */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->payrollReportRowDTO->getName(),
            'surname' => $this->payrollReportRowDTO->getSurname(),
            'department' => $this->payrollReportRowDTO->getDepartment(),
            'bonusType' => $this->payrollReportRowDTO->getBonusType(),
            'remunerationBase' => $this->payrollReportRowDTO->getRemunerationBase(),
            'additionToBase' => $this->payrollReportRowDTO->getAdditionToBase(),
            'salaryWithBonus' => $this->payrollReportRowDTO->getSalaryWithBonus(),
        ];
    }
}
