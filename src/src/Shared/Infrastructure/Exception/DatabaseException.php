<?php

namespace App\Shared\Infrastructure\Exception;

use Throwable;

final class DatabaseException extends InfrastructureException
{
    public static function fromPrevious(Throwable $previous): self
    {
        return new self(
            $previous->getMessage()
        );
    }
}