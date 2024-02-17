<?php

namespace App\Shared\UserInterface\View;

use App\Shared\Domain\ValueObject\Identifier;
use JsonSerializable;

final readonly class IdentifierView implements JsonSerializable
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
