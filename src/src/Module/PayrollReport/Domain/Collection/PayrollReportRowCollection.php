<?php

namespace App\Module\PayrollReport\Domain\Collection;

use App\Module\PayrollReport\Domain\Entity\PayrollReportRow;
use App\Shared\Domain\TypedCollection;

/** @extends TypedCollection<PayrollReportRow> */
final class PayrollReportRowCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return PayrollReportRow::class;
    }
}
