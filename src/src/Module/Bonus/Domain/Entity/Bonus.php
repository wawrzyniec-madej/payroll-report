<?php

namespace App\Module\Bonus\Domain\Entity;

use App\Module\Bonus\Domain\Enum\BonusNameEnum;
use App\Module\Bonus\Domain\Interface\BonusInterface;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\ValueObject\Identifier;

abstract class Bonus extends AggregateRoot implements BonusInterface
{
    public function __construct(
        private readonly Identifier $id,
        private readonly BonusNameEnum $name
    ) {
    }

    public function getId(): Identifier
    {
        return $this->id;
    }

    public function getName(): BonusNameEnum
    {
        return $this->name;
    }
}