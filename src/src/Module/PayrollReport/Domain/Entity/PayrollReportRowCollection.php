<?php

namespace App\Module\PayrollReport\Domain\Entity;

use App\Shared\Domain\TypedCollection;

/** @extends TypedCollection<PayrollReportRow> */
final class PayrollReportRowCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return PayrollReportRow::class;
    }
}