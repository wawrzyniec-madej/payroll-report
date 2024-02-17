<?php

namespace App\Module\PayrollReport\Infrastructure\Repository;

use App\Module\PayrollReport\Domain\Collection\PayrollReportRowCollection;
use App\Module\PayrollReport\Domain\Entity\PayrollReport;
use App\Module\PayrollReport\Domain\Entity\PayrollReportRow;
use App\Module\PayrollReport\Domain\Exception\PayrollReportNotFound;
use App\Module\PayrollReport\Domain\Interface\PayrollReportRepositoryInterface;
use App\Module\PayrollReport\Domain\ValueObject\BonusName;
use App\Module\PayrollReport\Domain\ValueObject\DepartmentName;
use App\Module\PayrollReport\Domain\ValueObject\EmployeeName;
use App\Module\PayrollReport\Domain\ValueObject\EmployeeSurname;
use App\Shared\Domain\DateTime;
use App\Shared\Domain\Enum\CurrencyEnum;
use App\Shared\Domain\ValueObject\Identifier;
use App\Shared\Domain\ValueObject\Money;
use App\Shared\Infrastructure\Exception\DatabaseException;
use Doctrine\DBAL\Connection;
use Exception;
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
                            'generation_date' => ':generationDate',
                        ]
                    )
                    ->setParameters([
                        'id' => $payrollReport->getId()->getValue(),
                        'generationDate' => $payrollReport->getGenerationDate()->toString(),
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
        } catch (Throwable $throwable) {
            throw DatabaseException::fromPrevious($throwable);
        }
    }

    public function getById(Identifier $id): PayrollReport
    {
        try {
            /** @var array{id:string, generation_date:string}|null $reportResult */
            $reportResult = $this->connection->createQueryBuilder()
                ->select('pr.*')
                ->from('payroll_report', 'pr')
                ->where(
                    'pr.id = :id'
                )
                ->setMaxResults(1)
                ->setParameter('id', $id->getValue())
                ->fetchAssociative();
        } catch (Exception $exception) {
            throw DatabaseException::fromPrevious($exception);
        }

        if (!is_array($reportResult)) {
            throw PayrollReportNotFound::create($id);
        }

        try {
            /** @var list<array{id:string, payroll_report_id:string, department:string, name:string, surname:string, remuneration_base_amount:int, remuneration_base_currency:string, addition_to_base_amount:int, addition_to_base_currency:string, bonus_type:string, salary_with_bonus_amount:int, salary_with_bonus_currency:string}> $rowResults */
            $rowResults = $this->connection->createQueryBuilder()
                ->select('prr.*')
                ->from('payroll_report_row', 'prr')
                ->where(
                    'prr.payroll_report_id = :payrollReportId'
                )
                ->setParameter('payrollReportId', $id->getValue())
                ->fetchAllAssociative();
        } catch (Exception $exception) {
            throw DatabaseException::fromPrevious($exception);
        }

        $rows = PayrollReportRowCollection::createEmpty();
        foreach ($rowResults as $rowResult) {
            $rows->add(
                PayrollReportRow::recreate(
                    new Identifier($rowResult['id']),
                    new EmployeeName($rowResult['name']),
                    new EmployeeSurname($rowResult['surname']),
                    new Money(
                        $rowResult['remuneration_base_amount'],
                        CurrencyEnum::from($rowResult['remuneration_base_currency'])
                    ),
                    new DepartmentName($rowResult['department']),
                    new BonusName($rowResult['bonus_type']),
                    new Money(
                        $rowResult['addition_to_base_amount'],
                        CurrencyEnum::from($rowResult['addition_to_base_currency'])
                    ),
                    new Money(
                        $rowResult['salary_with_bonus_amount'],
                        CurrencyEnum::from($rowResult['salary_with_bonus_currency'])
                    ),
                )
            );
        }

        return PayrollReport::recreate(
            new Identifier($reportResult['id']),
            DateTime::recreate($reportResult['generation_date']),
            $rows,
        );
    }
}
