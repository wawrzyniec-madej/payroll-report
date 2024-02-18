<?php

declare(strict_types=1);

namespace App\Module\Department\Domain\Entity;

use App\Module\Department\Domain\ValueObject\Name;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\ValueObject\Identifier;

final class Department extends AggregateRoot
{
    public function __construct(
        private readonly Identifier $id,
        private readonly Identifier $bonusId,
        private readonly Name $name
    ) {
    }

    public function getBonusId(): Identifier
    {
        return $this->bonusId;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getId(): Identifier
    {
        return $this->id;
    }
}
