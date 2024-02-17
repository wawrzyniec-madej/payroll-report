<?php

namespace App\Shared\UserInterface\Exception;

final class InvalidSortException extends UserInterfaceException
{
    public static function create(string $value, string $name): self
    {
        return new self(
            sprintf('Sort value [%s] for [%s] is invalid.', $value, $name)
        );
    }
}