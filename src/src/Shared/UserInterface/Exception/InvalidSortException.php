<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\Exception;

final class InvalidSortException extends UserInterfaceException
{
    public static function create(string $value, string $name): self
    {
        return new self(
            sprintf('Sort [%s] with value [%s] is invalid.', $name, $value)
        );
    }
}
