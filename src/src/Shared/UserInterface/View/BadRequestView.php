<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\View;

use JsonSerializable;

final readonly class BadRequestView implements JsonSerializable
{
    public function __construct(
        private string $message
    ) {
    }

    /** @return array{message: string} */
    public function jsonSerialize(): array
    {
        return [
            'message' => $this->message,
        ];
    }
}
