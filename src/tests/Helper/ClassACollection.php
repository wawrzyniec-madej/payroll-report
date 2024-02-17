<?php

namespace App\Tests\Helper;

use App\Shared\Domain\TypedCollection;

/** @extends TypedCollection<ClassA> */
final class ClassACollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return ClassA::class;
    }
}
