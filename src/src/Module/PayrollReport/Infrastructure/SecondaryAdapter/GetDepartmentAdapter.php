<?php

namespace App\Module\PayrollReport\Infrastructure\SecondaryAdapter;

use App\Module\Department\UserInterface\PrimaryAdapter\GetDepartmentAdapter as GetDepartmentPrimary;
use App\Module\PayrollReport\Domain\Exception\CannotGetDepartmentException;
use App\Module\PayrollReport\Domain\Interface\GetDepartmentInterface;
use App\Module\PayrollReport\Domain\ValueObject\Department;
use App\Module\PayrollReport\Domain\ValueObject\DepartmentName;
use App\Shared\Domain\ValueObject\Identifier;
use Exception;

final readonly class GetDepartmentAdapter implements GetDepartmentInterface
{
    public function __construct(
        private GetDepartmentPrimary $getDepartmentByIdAdapter
    ) {
    }

    public function getById(Identifier $departmentId): Department
    {
        try {
            $result = $this->getDepartmentByIdAdapter->get($departmentId->getValue());
        } catch (Exception) {
            throw CannotGetDepartmentException::create($departmentId);
        }

        return new Department(
            new DepartmentName($result['name']),
            new Identifier($result['bonusId'])
        );
    }
}