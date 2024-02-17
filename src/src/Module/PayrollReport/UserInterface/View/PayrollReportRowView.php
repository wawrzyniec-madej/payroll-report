<?php

namespace App\Module\PayrollReport\UserInterface\View;

use App\Module\PayrollReport\Domain\Entity\PayrollReportRow;
use App\Shared\UserInterface\View\MoneyView;
use JsonSerializable;

final readonly class PayrollReportRowView implements JsonSerializable
{
    public function __construct(
        private PayrollReportRow $payrollReportRow
    ) {
    }

    /** @return array{id: string, employee: array{name: string, surname: string}, bonusType: string, remunerationBase: JsonSerializable, additionToBase: JsonSerializable, salaryWithBonus: JsonSerializable} */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->payrollReportRow->getId()->getValue(),
            'employee' => [
                'name' => $this->payrollReportRow->getEmployeeName()->getValue(),
                'surname' => $this->payrollReportRow->getEmployeeSurname()->getValue(),
            ],
            'bonusType' => $this->payrollReportRow->getBonusName()->getValue(),
            'remunerationBase' => new MoneyView($this->payrollReportRow->getRemunerationBase()),
            'additionToBase' => new MoneyView($this->payrollReportRow->getAdditionToBase()),
            'salaryWithBonus' => new MoneyView($this->payrollReportRow->getSalaryWithBonus()),
        ];
    }
}
