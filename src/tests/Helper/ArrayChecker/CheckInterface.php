<?php

namespace App\Tests\Helper\ArrayChecker;

interface CheckInterface
{
    /** @throws CheckFailedException */
    public function check(mixed $value, string $key): void;
}
