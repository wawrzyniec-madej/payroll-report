<?php

namespace App\Tests\Helper\ArrayChecker;

final readonly class IsTypeCheck implements CheckInterface
{
    public function __construct(
        private mixed $expected
    ) {
    }

    public function check(mixed $value, string $key): void
    {
        $valueType = gettype($value);

        if ($valueType !== $this->expected) {
            throw CheckFailedException::create(sprintf('Type [%s] is not equal [%s]. On key: %s', $valueType, $this->expected, $key));
        }
    }
}
