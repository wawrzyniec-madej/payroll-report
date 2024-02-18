<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Infrastructure\Search\PayrollReportRows;

use App\Module\PayrollReport\Application\Collection\PayrollReportRowDTOCollection;
use App\Module\PayrollReport\Application\DTO\PayrollReportRowDTO;
use App\Module\PayrollReport\Application\Interface\SearchPayrollReportRowsInterface;
use App\Shared\Application\FilterAndSort\Collection\FilterCollection;
use App\Shared\Application\FilterAndSort\Sort;
use App\Shared\Domain\Exception\CollectionElementInvalidException;
use App\Shared\Domain\ValueObject\Identifier;
use App\Shared\Infrastructure\Exception\DatabaseException;
use App\Shared\Infrastructure\FilterAndSort\DbalFilterApplierChain;
use App\Shared\Infrastructure\FilterAndSort\DbalSortApplierChain;
use Doctrine\DBAL\Connection;

final readonly class DbalSearchPayrollReportRow implements SearchPayrollReportRowsInterface
{
    public function __construct(
        private Connection $connection,
        private DbalFilterApplierChain $dbalFilterApplierChain,
        private DbalSortApplierChain $dbalSortApplierChain
    ) {
    }

    /** @throws CollectionElementInvalidException */
    public function search(Identifier $id, FilterCollection $filters, ?Sort $sort): PayrollReportRowDTOCollection
    {
        $builder = $this->connection->createQueryBuilder()
            ->select(
                'prr.department',
                'prr.name',
                'prr.surname',
                'prr.remuneration_base_amount',
                'prr.addition_to_base_amount',
                'prr.bonus_type',
                'prr.salary_with_bonus_amount',
            )
            ->from('payroll_report_row', 'prr')
            ->where('prr.payroll_report_id = :payrollReportId')
            ->setParameter('payrollReportId', $id->getValue());

        $this->dbalFilterApplierChain->applySupported(
            $this,
            $filters,
            $builder
        );

        $this->dbalSortApplierChain->applySupported(
            $this,
            $sort,
            $builder
        );

        try {
            /** @var list<array{department:string, name:string, surname:string, remuneration_base_amount:int, addition_to_base_amount:int, bonus_type:string, salary_with_bonus_amount:int}> $results */
            $results = $builder->fetchAllAssociative();
        } catch (\Exception $exception) {
            throw DatabaseException::fromPrevious($exception);
        }

        $rowDTOs = PayrollReportRowDTOCollection::createEmpty();
        foreach ($results as $result) {
            $rowDTOs->add(
                new PayrollReportRowDTO(
                    $result['name'],
                    $result['surname'],
                    $result['department'],
                    $result['remuneration_base_amount'],
                    $result['addition_to_base_amount'],
                    $result['bonus_type'],
                    $result['salary_with_bonus_amount'],
                )
            );
        }

        return $rowDTOs;
    }
}
