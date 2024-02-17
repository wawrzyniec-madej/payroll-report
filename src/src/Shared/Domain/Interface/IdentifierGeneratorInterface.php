<?php

namespace App\Shared\Domain\Interface;

use App\Shared\Domain\ValueObject\Identifier;

interface IdentifierGeneratorInterface
{
    public function generate(): Identifier;
}