<?php

namespace App\Module\Bonus\Domain\Interface;

use App\Shared\Domain\ValueObject\Identifier;

interface BonusRepositoryInterface
{
    public function getOneById(Identifier $id): BonusInterface;
}
