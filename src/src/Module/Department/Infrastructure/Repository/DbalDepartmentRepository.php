<?php

declare(strict_types=1);

namespace App\Module\Department\Infrastructure\Repository;

use App\Module\Department\Domain\Entity\Department;
use App\Module\Department\Domain\Exception\DepartmentNotFoundException;
use App\Module\Department\Domain\Interface\DepartmentRepositoryInterface;
use App\Module\Department\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\Identifier;
use App\Shared\Infrastructure\Exception\DatabaseException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final readonly class DbalDepartmentRepository implements DepartmentRepositoryInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function getOneById(Identifier $id): Department
    {
        $builder = $this->connection->createQueryBuilder();
        $builder
            ->select('d.*')
            ->from('department', 'd')
            ->where('d.id = :id')
            ->setMaxResults(1)
            ->setParameter('id', $id->getValue());

        try {
            /** @var array{id:string, name:string, bonus_id:string}|null $result */
            $result = $builder->fetchAssociative();
        } catch (Exception $exception) {
            throw DatabaseException::fromPrevious($exception);
        }

        if (!is_array($result)) {
            throw DepartmentNotFoundException::forIdentifier($id);
        }

        return new Department(
            new Identifier($result['id']),
            new Identifier($result['bonus_id']),
            new Name($result['name'])
        );
    }
}
