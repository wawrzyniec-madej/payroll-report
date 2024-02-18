<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Application\Query;

use App\Module\PayrollReport\Application\Collection\PayrollReportRowDTOCollection;
use App\Module\PayrollReport\Application\Interface\SearchPayrollReportRowsInterface;
use App\Shared\Application\FilterAndSort\Collection\FilterCollection;
use App\Shared\Application\FilterAndSort\Sort;
use App\Shared\Domain\Exception\CollectionElementInvalidException;
use App\Shared\Domain\ValueObject\Identifier;

final readonly class SearchPayrollReportRowsQuery
{
    public function __construct(
        private SearchPayrollReportRowsInterface $searchPayrollReportRows
    ) {
    }

    /**
     * @throws CollectionElementInvalidException
     */
    public function search(
        Identifier $payrollReportId,
        FilterCollection $filters,
        ?Sort $sort
    ): PayrollReportRowDTOCollection {
        return $this->searchPayrollReportRows->search($payrollReportId, $filters, $sort);
    }
}
