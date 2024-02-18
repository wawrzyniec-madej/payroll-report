<?php

declare(strict_types=1);

namespace App\Module\Department\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;
use App\Shared\Domain\ValueObject\Identifier;

final class DepartmentNotFoundException extends DomainException
{
    public static function forIdentifier(Identifier $identifier): self
    {
        return new self(
            sprintf('Department with id [%s] was not found.', $identifier->getValue())
        );
    }
}
