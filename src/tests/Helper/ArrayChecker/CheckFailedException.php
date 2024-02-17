<?php

namespace App\Tests\Helper\ArrayChecker;

final class CheckFailedException extends \RuntimeException
{
    public static function create(string $message): self
    {
        return new self(
            sprintf('Check failed. Reason: %s', $message)
        );
    }
}
