<?php

namespace App\Module\PayrollReport\Infrastructure\SecondaryAdapter;

use App\Module\Department\UserInterface\PrimaryAdapter\GetDepartmentByIdAdapter;
use App\Module\PayrollReport\Domain\Interface\GetDepartmentInterface;
use App\Module\PayrollReport\Domain\ValueObject\Department;
use App\Module\PayrollReport\Domain\ValueObject\DepartmentName;
use App\Shared\Domain\ValueObject\Identifier;

final readonly class GetDepartmentAdapter implements GetDepartmentInterface
{
    public function __construct(
        private GetDepartmentByIdAdapter $getDepartmentByIdAdapter
    ) {
    }

    public function getById(Identifier $departmentId): Department
    {
        $result = $this->getDepartmentByIdAdapter->get($departmentId->getValue());

        return new Department(
            new DepartmentName($result['name']),
            new Identifier($result['bonusId'])
        );
    }
}