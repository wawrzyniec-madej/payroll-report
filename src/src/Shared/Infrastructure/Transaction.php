<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Shared\Application\Exception\TransactionFailedException;
use App\Shared\Application\Interface\TransactionInterface;
use App\Shared\Domain\Interface\IdentifierGeneratorInterface;
use App\Shared\Domain\ValueObject\Identifier;
use Closure;
use Doctrine\DBAL\Connection;
use Throwable;

/** If we added http calls, adding messages to queue or so to our app, this could serve as outbound pattern */
final class Transaction implements TransactionInterface
{
    private Identifier $id;

    public function __construct(
        private readonly IdentifierGeneratorInterface $identifierGenerator,
        private readonly Connection $connection,
        private bool $isRunning = false,
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
        /* Enable pass through without starting another transaction */
        if ($this->isRunning) {
            return $method();
        }

        $this->isRunning = true;
        $this->id = $this->identifierGenerator->generate();

        try {
            return $this->connection->transactional($method);
        } catch (Throwable $throwable) {
            throw TransactionFailedException::fromPrevious($throwable);
        } finally {
            $this->end();
        }
    }

    private function end(): void
    {
        $this->isRunning = false;
        unset($this->id);
    }

    public function isRunning(): bool
    {
        return $this->isRunning;
    }

    public function getId(): Identifier
    {
        return $this->id;
    }
}
