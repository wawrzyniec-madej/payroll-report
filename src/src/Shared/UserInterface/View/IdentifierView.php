<?php

namespace App\Shared\UserInterface\View;

use JsonSerializable;

final readonly class IdentifierView implements JsonSerializable
{
    public function __construct(
        private string $identifier
    ) {
    }

    public function jsonSerialize(): string
    {
        return $this->identifier;
    }
}