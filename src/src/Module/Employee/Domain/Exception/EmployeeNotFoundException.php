<?php

namespace App\Module\Employee\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;
use App\Shared\Domain\ValueObject\Identifier;

final class EmployeeNotFoundException extends DomainException
{
    public static function forIdentifier(Identifier $identifier): self
    {
        return new self(
            sprintf('Employee with id [%s] was not found.', $identifier->getValue())
        );
    }
}