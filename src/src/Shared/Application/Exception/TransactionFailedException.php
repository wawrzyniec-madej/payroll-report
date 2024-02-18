<?php

declare(strict_types=1);

namespace App\Shared\Application\Exception;

use Throwable;

final class TransactionFailedException extends ApplicationException
{
    public static function fromPrevious(Throwable $previous): self
    {
        return new self(
            'Transaction failed.',
            previous: $previous
        );
    }
}
