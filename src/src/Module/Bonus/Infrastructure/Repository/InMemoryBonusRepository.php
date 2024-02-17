<?php

namespace App\Module\Bonus\Infrastructure\Repository;

use App\Module\Bonus\Domain\Collection\BonusCollection;
use App\Module\Bonus\Domain\Entity\PercentageBonus;
use App\Module\Bonus\Domain\Entity\SeniorityBonus;
use App\Module\Bonus\Domain\Exception\BonusNotFoundException;
use App\Module\Bonus\Domain\Interface\BonusInterface;
use App\Module\Bonus\Domain\Interface\BonusRepositoryInterface;
use App\Module\Bonus\Domain\ValueObject\YearsOfSeniority;
use App\Shared\Domain\Enum\CurrencyEnum;
use App\Shared\Domain\ValueObject\Identifier;
use App\Shared\Domain\ValueObject\Money;
use App\Shared\Domain\ValueObject\Percentage;

final readonly class InMemoryBonusRepository implements BonusRepositoryInterface
{
    private BonusCollection $bonuses;

    public function __construct()
    {
        $this->bonuses = BonusCollection::fromSpread(
            new PercentageBonus(
                id: new Identifier('01HPT130YC9KJPRVKGE1N2PNR2'),
                percentage: new Percentage(10)
            ),
            new SeniorityBonus(
                id: new Identifier('01HPT1371DBA7EHCJYMAF8WJDR'),
                yearlyBonus: new Money(10000, CurrencyEnum::USD),
                maximumThreshold: new YearsOfSeniority(10)
            )
        );
    }

    public function getOneById(Identifier $id): BonusInterface
    {
        foreach ($this->bonuses as $bonus) {
            if ($bonus->getId()->isEqual($id)) {
                return $bonus;
            }
        }

        throw BonusNotFoundException::create($id);
    }
}