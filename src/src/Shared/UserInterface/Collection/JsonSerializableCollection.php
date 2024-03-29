<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\Collection;

use App\Shared\Components\TypedCollection;
use JsonSerializable;

/** @extends TypedCollection<JsonSerializable> */
final class JsonSerializableCollection extends TypedCollection implements JsonSerializable
{
    public function typeAllowed(): string
    {
        return JsonSerializable::class;
    }

    /** @return list<JsonSerializable> */
    public function jsonSerialize(): array
    {
        return $this->elements;
    }
}
