<?php

namespace App\Tests\Helper\ArrayChecker;

use Exception;

interface CheckInterface
{
    /** @throws CheckFailedException */
    public function check(mixed $value, string $key): void;
}