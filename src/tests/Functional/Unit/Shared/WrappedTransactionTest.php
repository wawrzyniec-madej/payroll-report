<?php

declare(strict_types=1);

namespace App\Tests\Functional\Unit\Shared;

use App\Shared\Application\Interface\TransactionInterface;
use App\Tests\Helper\KernelTestCase;

final class WrappedTransactionTest extends KernelTestCase
{
    private TransactionInterface $transaction;

    protected function setUp(): void
    {
        $this->transaction = self::getService(TransactionInterface::class);
    }

    public function testWrappingTransactionDoesntOverrideMainOne(): void
    {
        $this->transaction->start(function () {
            $transactionId = $this->transaction->getId();

            $this->transaction->start(function () use ($transactionId) {
                self::assertEquals(
                    $transactionId,
                    $this->transaction->getId()
                );
            });
        });
    }
}