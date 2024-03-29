<?php

declare(strict_types=1);

namespace App\Module\Department\Domain\Interface;

use App\Module\Department\Domain\Entity\Department;
use App\Module\Department\Domain\Exception\DepartmentNotFoundException;
use App\Shared\Domain\ValueObject\Identifier;

interface DepartmentRepositoryInterface
{
    /** @throws DepartmentNotFoundException */
    public function getOneById(Identifier $id): Department;
}
