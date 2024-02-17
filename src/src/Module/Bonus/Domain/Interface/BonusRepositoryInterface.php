<?php

namespace App\Module\Bonus\Domain\Interface;

use App\Module\Bonus\Domain\Exception\BonusNotFoundException;
use App\Module\Bonus\Domain\Exception\InvalidYearsOfSeniorityException;
use App\Module\Bonus\Domain\Exception\UnsupportedBonusTypeException;
use App\Shared\Domain\Exception\InvalidPercentageException;
use App\Shared\Domain\ValueObject\Identifier;

interface BonusRepositoryInterface
{
    /**
     * @throws UnsupportedBonusTypeException
     * @throws InvalidYearsOfSeniorityException
     * @throws BonusNotFoundException
     * @throws InvalidPercentageException
     */
    public function getOneById(Identifier $id): BonusInterface;
}
