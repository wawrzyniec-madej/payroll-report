<?php

namespace App\Module\PayrollReport\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

final class InvalidYearsOfSeniorityException extends DomainException
{
    public static function create(int $value): self
    {
        return new self(
            sprintf('Years of seniority [%d] is invalid.', $value)
        );
    }
}
