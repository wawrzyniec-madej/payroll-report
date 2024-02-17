<?php

namespace App\Shared\UserInterface\View;

use JsonSerializable;

final readonly class ResultView implements JsonSerializable
{
    public function __construct(
        private JsonSerializable $result
    ) {
    }

    /** @return array{result: mixed} */
    public function jsonSerialize(): array
    {
        return [
            'result' => $this->result
        ];
    }
}