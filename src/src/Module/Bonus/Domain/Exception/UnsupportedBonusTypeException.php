<?php

namespace App\Module\Bonus\Domain\Exception;

use App\Module\Bonus\Domain\Enum\BonusTypeEnum;
use App\Shared\Domain\Exception\DomainException;

final class UnsupportedBonusTypeException extends DomainException
{
    public static function create(string $value): self
    {
        return new self(
            sprintf(
                'Bonus type [%s] is unsupported. Allowed: [%s].',
                $value,
                implode(',', BonusTypeEnum::getValues())
            )
        );
    }
}
