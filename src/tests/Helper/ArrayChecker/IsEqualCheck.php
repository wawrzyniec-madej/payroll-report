<?php

namespace App\Tests\Helper\ArrayChecker;

final readonly class IsEqualCheck implements CheckInterface
{
    public function __construct(
        private mixed $expected
    ) {
    }

    public function check(mixed $value, string $key): void
    {
        if ($value !== $this->expected) {
            throw CheckFailedException::create(
                sprintf('Value [%s] is not equal [%s]. On key: %s', $value, $this->expected, $key)
            );
        }
    }
}