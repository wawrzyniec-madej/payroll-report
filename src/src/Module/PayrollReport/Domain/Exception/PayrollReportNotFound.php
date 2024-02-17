<?php

namespace App\Module\PayrollReport\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;
use App\Shared\Domain\ValueObject\Identifier;

final class PayrollReportNotFound extends DomainException
{
    public static function create(Identifier $id): self
    {
        return new self(
            sprintf('Payroll report with id [%s] was not found.', $id->getValue())
        );
    }
}