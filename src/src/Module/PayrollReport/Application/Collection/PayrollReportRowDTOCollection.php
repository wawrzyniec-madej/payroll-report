<?php

namespace App\Module\PayrollReport\Application\Collection;

use App\Module\PayrollReport\Application\DTO\PayrollReportRowDTO;
use App\Shared\Domain\TypedCollection;

/** @extends TypedCollection<PayrollReportRowDTO> */
final class PayrollReportRowDTOCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return PayrollReportRowDTO::class;
    }
}