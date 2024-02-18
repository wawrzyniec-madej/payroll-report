<?php

declare(strict_types=1);

namespace App\Module\Bonus\Domain\Collection;

use App\Module\Bonus\Domain\Interface\BonusInterface;
use App\Shared\TypedCollection;

/** @extends TypedCollection<BonusInterface> */
final class BonusCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return BonusInterface::class;
    }
}
