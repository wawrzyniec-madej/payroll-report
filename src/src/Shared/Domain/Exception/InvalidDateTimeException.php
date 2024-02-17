<?php

namespace App\Shared\Domain\Exception;

use Exception;

final class InvalidDateTimeException extends DomainException
{
    public static function fromPrevious(Exception $previous): self
    {
        return new self(
            $previous->getMessage()
        );
    }
}
