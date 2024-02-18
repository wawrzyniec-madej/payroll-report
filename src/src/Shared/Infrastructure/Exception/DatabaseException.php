<?php

declare(strict_types=1);

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
