<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

final class CollectionElementInvalidException extends DomainException
{
    /**
     * @param class-string $provided
     * @param class-string $expected
     */
    public static function create(string $provided, string $expected): self
    {
        return new self(
            sprintf('Collection element of type [%s] is invalid. Expected %s.', $provided, $expected)
        );
    }
}
