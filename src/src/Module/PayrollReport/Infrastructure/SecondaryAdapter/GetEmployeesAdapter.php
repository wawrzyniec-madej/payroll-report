<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Infrastructure\SecondaryAdapter;

use App\Module\Employee\UserInterface\PrimaryAdapter\GetEmployeesAdapter as GetEmployeesPrimary;
use App\Module\PayrollReport\Domain\Collection\EmployeeCollection;
use App\Module\PayrollReport\Domain\Interface\GetAllEmployeesInterface;
use App\Module\PayrollReport\Domain\ValueObject\Employee;
use App\Module\PayrollReport\Domain\ValueObject\EmployeeName;
use App\Module\PayrollReport\Domain\ValueObject\EmployeeSurname;
use App\Module\PayrollReport\Domain\ValueObject\YearsOfSeniority;
use App\Shared\Domain\DateTime;
use App\Shared\Domain\Enum\CurrencyEnum;
use App\Shared\Domain\Money;
use App\Shared\Domain\ValueObject\Identifier;

final readonly class GetEmployeesAdapter implements GetAllEmployeesInterface
{
    public function __construct(
        private GetEmployeesPrimary $getAllEmployees
    ) {
    }

    public function getAll(): EmployeeCollection
    {
        $results = $this->getAllEmployees->get();

        $employees = EmployeeCollection::createEmpty();
        foreach ($results as $result) {
            $employees->add(
                new Employee(
                    new EmployeeName($result['name']),
                    new EmployeeSurname($result['surname']),
                    new Money(
                        $result['baseSalaryAmount'],
                        CurrencyEnum::from($result['baseSalaryCurrency'])
                    ),
                    new Identifier($result['departmentId']),
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
