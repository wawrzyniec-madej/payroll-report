<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Domain\Collection;

use App\Module\PayrollReport\Domain\Entity\PayrollReportRow;
use App\Shared\Components\TypedCollection;

/** @extends TypedCollection<PayrollReportRow> */
final class PayrollReportRowCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return PayrollReportRow::class;
    }
}
