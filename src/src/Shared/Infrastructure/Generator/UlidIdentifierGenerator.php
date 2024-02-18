<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Generator;

use App\Shared\Domain\Interface\IdentifierGeneratorInterface;
use App\Shared\Domain\ValueObject\Identifier;
use Symfony\Component\Uid\Ulid;

final class UlidIdentifierGenerator implements IdentifierGeneratorInterface
{
    public function generate(): Identifier
    {
        return new Identifier(
            Ulid::generate()
        );
    }
}
