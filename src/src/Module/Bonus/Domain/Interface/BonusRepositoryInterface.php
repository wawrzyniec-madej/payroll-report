<?php

namespace App\Module\Bonus\Domain\Interface;

use App\Module\Bonus\Domain\Exception\BonusNotFoundException;
use App\Shared\Domain\ValueObject\Identifier;

interface BonusRepositoryInterface
{
    /** @throws BonusNotFoundException */
    public function getOneById(Identifier $id): BonusInterface;
}