<?php

namespace App\Module\Department\Domain\Entity;

use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\ValueObject\Identifier;

final class Department extends AggregateRoot
{
    public function __construct(
        private readonly Identifier $id,
        private readonly Identifier $bonusId
    ) {
    }

    public function getId(): Identifier
    {
        return $this->id;
    }

    public function getBonusId(): Identifier
    {
        return $this->bonusId;
    }
}