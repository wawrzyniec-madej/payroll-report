<?php

declare(strict_types=1);

namespace App\Module\Bonus\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

final class InvalidPercentageException extends DomainException
{
    public static function create(int $value): self
    {
        return new self(
            sprintf('Percentage [%d] is invalid.', $value)
        );
    }
}
