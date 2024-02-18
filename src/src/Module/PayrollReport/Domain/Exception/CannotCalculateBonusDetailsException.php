<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;
use App\Shared\Domain\ValueObject\Identifier;

final class CannotCalculateBonusDetailsException extends DomainException
{
    public static function create(Identifier $id): self
    {
        return new self(
            sprintf('Cannot calculate bonus details for id [%s].', $id->getValue())
        );
    }
}
