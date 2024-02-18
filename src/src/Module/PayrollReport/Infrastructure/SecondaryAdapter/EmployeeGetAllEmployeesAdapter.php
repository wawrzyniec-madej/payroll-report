<?php

namespace App\Module\PayrollReport\Infrastructure\SecondaryAdapter;

use App\Module\Department\UserInterface\PrimaryAdapter\GetDepartmentByIdAdapter;
use App\Module\Employee\UserInterface\PrimaryAdapter\GetAllEmployeesAdapter as GetAllEmployeesPrimary;
use App\Module\PayrollReport\Domain\Collection\EmployeeCollection;
use App\Module\PayrollReport\Domain\Exception\CannotGetDepartmentException;
use App\Module\PayrollReport\Domain\Interface\GetAllEmployeesInterface;
use App\Module\PayrollReport\Domain\ValueObject\Department;
use App\Module\PayrollReport\Domain\ValueObject\DepartmentName;
use App\Module\PayrollReport\Domain\ValueObject\Employee;
use App\Module\PayrollReport\Domain\ValueObject\EmployeeName;
use App\Module\PayrollReport\Domain\ValueObject\EmployeeSurname;
use App\Module\PayrollReport\Domain\ValueObject\YearsOfSeniority;
use App\Shared\Domain\DateTime;
use App\Shared\Domain\Enum\CurrencyEnum;
use App\Shared\Domain\Money;
use App\Shared\Domain\ValueObject\Identifier;

final readonly class EmployeeGetAllEmployeesAdapter implements GetAllEmployeesInterface
{
    public function __construct(
        private GetAllEmployeesPrimary $getAllEmployees,
        private GetDepartmentByIdAdapter $getDepartmentById
    ) {
    }

    public function getAll(): EmployeeCollection
    {
        $results = $this->getAllEmployees->get();

        $employees = EmployeeCollection::createEmpty();
        foreach ($results as $result) {
            $departmentId = new Identifier($result['departmentId']);

            try {
                $department = $this->getDepartmentById->get($departmentId->getValue());
            } catch (\Exception) {
                throw CannotGetDepartmentException::create($departmentId);
            }

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
