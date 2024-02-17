<?php

namespace App\Module\Department\Domain\Exception;

use App\Shared\Domain\ValueObject\Identifier;

final class DepartmentNotFoundException
{
    public static function forIdentifier(Identifier $identifier): self
    {
        return new self(
            sprintf('Department with id [%s] was not found.', $identifier->getValue())
        );
    }
}