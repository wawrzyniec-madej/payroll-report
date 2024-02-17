<?php

namespace App\Module\Bonus\Domain\Entity;

use App\Module\Bonus\Domain\Enum\BonusTypeEnum;
use App\Module\Bonus\Domain\Interface\BonusInterface;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\ValueObject\Identifier;

abstract class Bonus extends AggregateRoot implements BonusInterface
{
    public function __construct(
        private readonly Identifier $id,
        private readonly BonusTypeEnum $name
    ) {
    }

    public function getId(): Identifier
    {
        return $this->id;
    }

    public function getName(): BonusTypeEnum
    {
        return $this->name;
    }
}