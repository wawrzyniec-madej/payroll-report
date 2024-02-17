<?php

namespace App\Module\PayrollReport\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;
use App\Shared\Domain\ValueObject\Identifier;

final class CannotGetBonusDetailsException extends DomainException
{
    public static function create(Identifier $id): self
    {
        return new self(
            sprintf('Cannot get bonus details for id [%s].', $id->getValue())
        );
    }
}