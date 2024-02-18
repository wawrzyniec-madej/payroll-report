<?php

declare(strict_types=1);

namespace App\Shared\Application\Interface;

use Closure;

/**
 * @template T of mixed
 */
interface TransactionInterface
{
    /** @return T */
    public function start(Closure $method): mixed;

    public function end(): void;
}
