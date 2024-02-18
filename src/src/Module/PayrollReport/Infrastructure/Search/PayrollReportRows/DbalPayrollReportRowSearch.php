<?php

namespace App\Module\PayrollReport\Infrastructure\Search\PayrollReportRows;

use App\Module\PayrollReport\Application\Collection\PayrollReportRowDTOCollection;
use App\Module\PayrollReport\Application\DTO\PayrollReportRowDTO;
use App\Module\PayrollReport\Application\Interface\SearchPayrollReportRowsInterface;
use App\Module\PayrollReport\Infrastructure\Search\PayrollReportRows\FilterApplier\DepartmentFilterApplier;
use App\Module\PayrollReport\Infrastructure\Search\PayrollReportRows\FilterApplier\NameFilterApplier;
use App\Module\PayrollReport\Infrastructure\Search\PayrollReportRows\FilterApplier\SurnameFilterApplier;
use App\Module\PayrollReport\Infrastructure\Search\PayrollReportRows\SortApplier\AdditionToBaseSortApplier;
use App\Module\PayrollReport\Infrastructure\Search\PayrollReportRows\SortApplier\BonusTypeSortApplier;
use App\Module\PayrollReport\Infrastructure\Search\PayrollReportRows\SortApplier\DepartmentSortApplier;
use App\Module\PayrollReport\Infrastructure\Search\PayrollReportRows\SortApplier\NameSortApplier;
use App\Module\PayrollReport\Infrastructure\Search\PayrollReportRows\SortApplier\RemunerationBaseSortApplier;
use App\Module\PayrollReport\Infrastructure\Search\PayrollReportRows\SortApplier\SalaryWithBonusSortApplier;
use App\Module\PayrollReport\Infrastructure\Search\PayrollReportRows\SortApplier\SurnameSortApplier;
use App\Shared\Application\FilterAndSort\Collection\FilterCollection;
use App\Shared\Application\FilterAndSort\Sort;
use App\Shared\Domain\Exception\CollectionElementInvalidException;
use App\Shared\Domain\ValueObject\Identifier;
use App\Shared\Infrastructure\Collection\DbalFilterApplierCollection;
use App\Shared\Infrastructure\Collection\DbalSortApplierCollection;
use App\Shared\Infrastructure\Exception\DatabaseException;
use Doctrine\DBAL\Connection;

final readonly class DbalPayrollReportRowSearch implements SearchPayrollReportRowsInterface
{
    /** This values could be wired by some tagged iterator, but I think the scope is too small for now */
    private DbalFilterApplierCollection $filterAppliers;
    private DbalSortApplierCollection $sortAppliers;

    /** @throws CollectionElementInvalidException */
    public function __construct(
        private Connection $connection
    ) {
        $this->filterAppliers = DbalFilterApplierCollection::createFromSpread(
            new DepartmentFilterApplier(),
            new NameFilterApplier(),
            new SurnameFilterApplier()
        );

        $this->sortAppliers = DbalSortApplierCollection::createFromSpread(
            new NameSortApplier(),
            new AdditionToBaseSortApplier(),
            new BonusTypeSortApplier(),
            new DepartmentSortApplier(),
            new RemunerationBaseSortApplier(),
            new SalaryWithBonusSortApplier(),
            new SurnameSortApplier()
        );
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

        $this->filterAppliers->applyAll(
            $filters,
            $builder
        );

        if ($sort) {
            $this->sortAppliers->applyAll($sort, $builder);
        }

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
