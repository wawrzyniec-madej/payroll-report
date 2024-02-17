<?php

namespace App\Shared\Infrastructure;

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
