<?php

namespace App\Module\PayrollReport\Infrastructure\Repository;

use App\Module\PayrollReport\Domain\Entity\PayrollReport;
use App\Module\PayrollReport\Domain\Interface\PayrollReportRepositoryInterface;
use App\Shared\Infrastructure\Exception\DatabaseException;
use Doctrine\DBAL\Connection;

final readonly class DbalPayrollReportRepository implements PayrollReportRepositoryInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function save(PayrollReport $payrollReport): void
    {
        try {
            $this->connection->transactional(function () use ($payrollReport) {
                $builder = $this->connection->createQueryBuilder();
                $builder
                    ->insert('payroll_report')
                    ->values(
                        [
                            'id' => ':id',
                            'generation_date' => ':generationDate',
                        ]
                    )
                    ->setParameters([
                        'id' => $payrollReport->getId()->getValue(),
                        'generationDate' => $payrollReport->getGenerationDate()->toString(),
                    ])
                    ->executeStatement();

                /* @todo refactor to multiple values at once */
                foreach ($payrollReport->getRows() as $payrollReportRow) {
                    $builder
                        ->insert('payroll_report_row')
                        ->values(
                            [
                                'id' => ':id',
                                'payroll_report_id' => ':payrollReportId',
                                'department' => ':department',
                                'name' => ':name',
                                'surname' => ':surname',
                                'remuneration_base_amount' => ':remunerationBaseAmount',
                                'remuneration_base_currency' => ':remunerationBaseCurrency',
                                'addition_to_base_amount' => ':additionToBaseAmount',
                                'addition_to_base_currency' => ':additionToBaseCurrency',
                                'bonus_type' => ':bonusType',
                                'salary_with_bonus_amount' => ':salaryWithBonusAmount',
                                'salary_with_bonus_currency' => ':salaryWithBonusCurrency',
                            ]
                        )
                        ->setParameters([
                            'id' => $payrollReportRow->getId()->getValue(),
                            'payrollReportId' => $payrollReport->getId()->getValue(),
                            'name' => $payrollReportRow->getEmployeeName()->getValue(),
                            'surname' => $payrollReportRow->getEmployeeSurname()->getValue(),
                            'department' => $payrollReportRow->getDepartmentName()->getValue(),
                            'remunerationBaseAmount' => $payrollReportRow->getRemunerationBase()->getAmount(),
                            'remunerationBaseCurrency' => $payrollReportRow->getRemunerationBase()->getCurrency(
                            )->value,
                            'additionToBaseAmount' => $payrollReportRow->getAdditionToBase()->getAmount(),
                            'additionToBaseCurrency' => $payrollReportRow->getAdditionToBase()->getCurrency()->value,
                            'bonusType' => $payrollReportRow->getBonusName()->getValue(),
                            'salaryWithBonusAmount' => $payrollReportRow->getSalaryWithBonus()->getAmount(),
                            'salaryWithBonusCurrency' => $payrollReportRow->getSalaryWithBonus()->getCurrency()->value,
                        ])
                        ->executeStatement();
                }
            });
        } catch (\Throwable $throwable) {
            throw DatabaseException::fromPrevious($throwable);
        }
    }
}
