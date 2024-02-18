<?php

declare(strict_types=1);

namespace App\Module\Bonus\Infrastructure\Repository;

use App\Module\Bonus\Domain\Entity\PercentageBonus;
use App\Module\Bonus\Domain\Entity\SeniorityBonus;
use App\Module\Bonus\Domain\Enum\BonusTypeEnum;
use App\Module\Bonus\Domain\Exception\BonusNotFoundException;
use App\Module\Bonus\Domain\Exception\UnsupportedBonusTypeException;
use App\Module\Bonus\Domain\Interface\BonusInterface;
use App\Module\Bonus\Domain\Interface\BonusRepositoryInterface;
use App\Module\Bonus\Domain\ValueObject\Percentage;
use App\Module\Bonus\Domain\ValueObject\YearsOfSeniority;
use App\Shared\Domain\Enum\CurrencyEnum;
use App\Shared\Domain\Money;
use App\Shared\Domain\ValueObject\Identifier;
use App\Shared\Infrastructure\Exception\DatabaseException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final readonly class DbalBonusRepository implements BonusRepositoryInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function getOneById(Identifier $id): BonusInterface
    {
        $builder = $this->connection->createQueryBuilder();
        $builder
            ->select('b.*')
            ->from('bonus', 'b')
            ->setMaxResults(1)
            ->where('b.id = :id')
            ->setParameter('id', $id->getValue());

        try {
            /** @var array{id:string, type:string, yearly_bonus_amount:int, yearly_bonus_currency:string, employment_threshold:int, percentage:int}|null $result */
            $result = $builder->fetchAssociative();
        } catch (Exception $exception) {
            throw DatabaseException::fromPrevious($exception);
        }

        if (!is_array($result)) {
            throw BonusNotFoundException::create($id);
        }

        $id = new Identifier($result['id']);

        $type = BonusTypeEnum::tryFrom($result['type']);
        if (!$type) {
            throw UnsupportedBonusTypeException::create($result['type']);
        }

        return match ($type) {
            BonusTypeEnum::SENIORITY => new SeniorityBonus(
                $id,
                new Money($result['yearly_bonus_amount'], CurrencyEnum::from($result['yearly_bonus_currency'])),
                new YearsOfSeniority($result['employment_threshold'])
            ),
            BonusTypeEnum::PERCENTAGE => new PercentageBonus(
                $id,
                new Percentage($result['percentage'])
            )
        };
    }
}
