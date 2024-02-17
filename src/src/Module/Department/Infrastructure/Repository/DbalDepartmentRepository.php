<?php

namespace App\Module\Department\Infrastructure\Repository;

use App\Module\Department\Domain\Entity\Department;
use App\Module\Department\Domain\Interface\DepartmentRepositoryInterface;
use App\Shared\Domain\ValueObject\Identifier;
use Doctrine\DBAL\Connection;

final class DbalDepartmentRepository implements DepartmentRepositoryInterface
{
    public function __construct(
        private readonly Connection $connection
    ) {
    }

    public function getOneById(Identifier $identifier): Department
    {
        return new Department();
    }
}