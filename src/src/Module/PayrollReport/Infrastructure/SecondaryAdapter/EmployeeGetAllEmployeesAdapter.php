<?php

namespace App\Module\PayrollReport\Infrastructure\SecondaryAdapter;

use App\Module\Department\UserInterface\PrimaryAdapter\GetDepartmentById;
use App\Module\Employee\UserInterface\PrimaryAdapter\GetAllEmployees as GetAllEmployeesPrimary;
use App\Module\PayrollReport\Domain\Collection\EmployeeCollection;
use App\Module\PayrollReport\Domain\Interface\GetAllEmployeesInterface;
use App\Module\PayrollReport\Domain\ValueObject\Department;
use App\Module\PayrollReport\Domain\ValueObject\DepartmentName;
use App\Module\PayrollReport\Domain\ValueObject\Employee;
use App\Module\PayrollReport\Domain\ValueObject\EmployeeName;
use App\Module\PayrollReport\Domain\ValueObject\EmployeeSurname;
use App\Module\PayrollReport\Domain\ValueObject\YearsOfSeniority;
use App\Shared\Domain\DateTime;
use App\Shared\Domain\Enum\CurrencyEnum;
use App\Shared\Domain\ValueObject\Identifier;
use App\Shared\Domain\ValueObject\Money;

final readonly class EmployeeGetAllEmployeesAdapter implements GetAllEmployeesInterface
{
    public function __construct(
        private GetAllEmployeesPrimary $getAllEmployees,
        private GetDepartmentById $getDepartmentById
    ) {
    }

    public function getAll(): EmployeeCollection
    {
        $results = $this->getAllEmployees->get();

        $employees = EmployeeCollection::createEmpty();
        foreach ($results as $result) {
            $department = $this->getDepartmentById->get($result['departmentId']);

            $employees->add(
                new Employee(
                    new EmployeeName($result['name']),
                    new EmployeeSurname($result['surname']),
                    new Money(
                        $result['baseSalaryAmount'],
                        CurrencyEnum::from($result['baseSalaryCurrency'])
                    ),
                    new Department(
                        new DepartmentName($department['name']),
                        new Identifier($department['bonusId'])
                    ),
                    new YearsOfSeniority(
                        DateTime::recreate($result['dateOfEmployment'])->getNumberOfYearsBetween(
                            DateTime::now()
                        )
                    )
                )
            );
        }

        return $employees;
    }
}