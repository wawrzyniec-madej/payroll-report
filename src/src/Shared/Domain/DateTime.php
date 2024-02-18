<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use App\Shared\Domain\Exception\InvalidDateTimeException;

final readonly class DateTime
{
    private const STRING_FORMAT = 'Y-m-d H:i:s';

    private function __construct(
        private \DateTimeImmutable $dateTimeImmutable
    ) {
    }

    /** @throws InvalidDateTimeException */
    public static function recreate(string $value): self
    {
        try {
            return new self(
                new \DateTimeImmutable($value)
            );
        } catch (\Exception $exception) {
            throw InvalidDateTimeException::fromPrevious($exception);
        }
    }

    public static function now(): self
    {
        return new self(
            new \DateTimeImmutable()
        );
    }

    public function toString(): string
    {
        return $this->dateTimeImmutable->format(self::STRING_FORMAT);
    }

    public function getNumberOfYearsBetween(self $compared): int
    {
        $difference = $this->dateTimeImmutable->diff(
            $compared->dateTimeImmutable
        );

        return (int) $difference->format('%y');
    }
}
