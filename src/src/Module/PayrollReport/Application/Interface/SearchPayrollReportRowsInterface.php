<?php

namespace App\Module\PayrollReport\Application\Interface;

use App\Module\PayrollReport\Application\Collection\PayrollReportRowDTOCollection;
use App\Shared\Application\FilterAndSort\Collection\FilterCollection;
use App\Shared\Application\FilterAndSort\Sort;
use App\Shared\Domain\ValueObject\Identifier;

interface SearchPayrollReportRowsInterface
{
    public function search(Identifier $id, FilterCollection $filters, ?Sort $sort): PayrollReportRowDTOCollection;
}
