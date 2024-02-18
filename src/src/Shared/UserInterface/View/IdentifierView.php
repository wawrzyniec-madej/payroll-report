<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\View;

use App\Shared\Domain\ValueObject\Identifier;

final readonly class IdentifierView implements \JsonSerializable
{
    public function __construct(
        private Identifier $identifier
    ) {
    }

    public function jsonSerialize(): string
    {
        return $this->identifier->getValue();
    }
}
