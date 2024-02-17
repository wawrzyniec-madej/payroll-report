<?php

namespace App\Module\PayrollReport\Infrastructure\Repository;

use App\Module\PayrollReport\Domain\Entity\PayrollReport;
use App\Module\PayrollReport\Domain\Interface\PayrollReportRepositoryInterface;
use App\Shared\Infrastructure\Exception\DatabaseException;
use Doctrine\DBAL\Connection;
use Throwable;

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
                            'generation_date' => ':generationDate'
                        ]
                    )
                    ->setParameters([
                        'id' => $payrollReport->getId()->getValue(),
                        'generationDate' => $payrollReport->getGenerationDate()->toString()
                    ])
                    ->executeStatement();

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
                                'salary_with_bonus_currency' => ':salaryWithBonusCurrency'
                            ]
                        )
                        ->setParameters([
                            'id' => $payrollReportRow->getId()->getValue(),
                            'name' => $payrollReportRow->getEmployee()->getName()->getValue(),
                            'surname' => $payrollReportRow->getEmployee()->getSurname()->getValue(),
                            'payrollReportId' => $payrollReport->getId()->getValue(),
                            'department' => $payrollReportRow->getEmployee()->getDepartment()->getName()->getValue(),
                            'remunerationBaseAmount' => $payrollReportRow->getEmployee()->getRemunerationBase(
                            )->getAmount(),
                            'remunerationBaseCurrency' => $payrollReportRow->getEmployee()->getRemunerationBase(
                            )->getCurrency()->value,
                            'additionToBaseAmount' => $payrollReportRow->getBonusDetails()->getAdditionToBase(
                            )->getAmount(),
                            'additionToBaseCurrency' => $payrollReportRow->getBonusDetails()->getAdditionToBase(
                            )->getCurrency()->value,
                            'bonusType' => $payrollReportRow->getBonusDetails()->getName()->getValue(),
                            'salaryWithBonusAmount' => $payrollReportRow->getBonusDetails()->getSalaryWithBonus(
                            )->getAmount(),
                            'salaryWithBonusCurrency' => $payrollReportRow->getBonusDetails()->getSalaryWithBonus(
                            )->getCurrency()->value
                        ])
                        ->executeStatement();
                }
            });
        } catch (Throwable $throwable) {
            throw DatabaseException::fromPrevious($throwable);
        }
    }
}