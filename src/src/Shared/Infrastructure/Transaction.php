<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Shared\Application\Exception\TransactionFailedException;
use App\Shared\Application\Interface\TransactionInterface;
use Closure;
use Doctrine\DBAL\Connection;
use Throwable;

/** If we added http calls, adding messages to queue or so to our app, this could serve as outbound pattern */
final class Transaction implements TransactionInterface
{
    public function __construct(
        private readonly Connection $connection,
        private bool $isRunning = false
    ) {
    }

    /**
     * @template T
     *
     * @param Closure():T $method
     */
    public function start(
        Closure $method
    ): mixed {
        if ($this->isRunning) {
            $method();
        }

        $this->isRunning = true;

        try {
            return $this->connection->transactional($method);
        } catch (Throwable $throwable) {
            throw TransactionFailedException::fromPrevious($throwable);
        } finally {
            $this->end();
        }
    }

    public function end(): void
    {
        $this->isRunning = false;
    }

    public function isRunning(): bool
    {
        return $this->isRunning;
    }
}
