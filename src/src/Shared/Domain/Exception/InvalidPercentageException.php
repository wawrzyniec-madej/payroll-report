<?php

namespace App\Shared\Domain\Exception;

final class InvalidPercentageException extends DomainException
{
    public static function create(int $value): self
    {
        return new self(
            sprintf('Percentage [%d] is invalid.', $value)
        );
    }
}
