<?php

namespace App\Module\Department\Application\Query;

use App\Module\Department\Domain\Entity\Department;
use App\Module\Department\Domain\Interface\DepartmentRepositoryInterface;
use App\Shared\Domain\ValueObject\Identifier;

final readonly class GetDepartmentByIdQuery
{
    public function __construct(
        private DepartmentRepositoryInterface $departmentRepository
    ) {
    }

    public function get(Identifier $id): Department
    {
        return $this->departmentRepository->getOneById($id);
    }
}
