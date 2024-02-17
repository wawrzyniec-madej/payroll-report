<?php

namespace App\Module\Bonus\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;
use App\Shared\Domain\ValueObject\Identifier;

final class BonusNotFoundException extends DomainException
{
    public static function create(Identifier $id): self
    {
        return new self(
            sprintf('Bonus with id [%s] was not found.', $id->getValue())
        );
    }
}