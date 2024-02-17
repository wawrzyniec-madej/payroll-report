<?php

namespace App\Tests\Helper;

use App\Shared\Domain\ValueObject\Identifier;
use Symfony\Component\Uid\Ulid;

final class IdentifierHelper
{
    public static function generateUlid(): Identifier
    {
        return new Identifier(Ulid::generate());
    }
}
