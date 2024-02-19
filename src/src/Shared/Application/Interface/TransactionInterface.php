<?php

declare(strict_types=1);

namespace App\Shared\Application\Interface;

use App\Shared\Domain\ValueObject\Identifier;
use Closure;

/**
 * @template T
 */
interface TransactionInterface
{
    /** @return T */
    public function start(Closure $method): mixed;

    public function getId(): Identifier;
}
