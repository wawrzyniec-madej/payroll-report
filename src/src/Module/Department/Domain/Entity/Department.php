<?php

namespace App\Module\Department\Domain\Entity;

use App\Module\Department\Domain\ValueObject\Name;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\ValueObject\Identifier;

final class Department extends AggregateRoot
{
    public function __construct(
        private Identifier $id,
        private Identifier $bonusId,
        private Name $name
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

    public function getName(): Name
    {
        return $this->name;
    }
}
