<?php

namespace App\Module\Employee\UserInterface\PrimaryAdapter;

use App\Module\Employee\Application\Query\GetAllEmployeesQuery;
use App\Shared\Domain\Exception\CollectionElementInvalidException;
use App\Shared\Domain\Exception\InvalidDateTimeException;

final readonly class GetAllEmployees
{
    public function __construct(
        private GetAllEmployeesQuery $getAllEmployeesQuery
    ) {
    }

    /**
     * @return list<array{id: string, name: string, surname: string, dateOfEmployment: string, departmentId: string, baseSalaryAmount: int, baseSalaryCurrency: string}>
     * @throws CollectionElementInvalidException
     * @throws InvalidDateTimeException
     */
    public function get(): array
    {
        $employees = $this->getAllEmployeesQuery->get();

        $data = [];
        foreach ($employees as $employee) {
            $data[] = [
                'id' => $employee->getId()->getValue(),
                'name' => $employee->getName()->getValue(),
                'surname' => $employee->getSurname()->getValue(),
                'dateOfEmployment' => $employee->getDateOfEmployment()->toString(),
                'departmentId' => $employee->getDepartmentId()->getValue(),
                'baseSalaryAmount' => $employee->getBaseSalary()->getAmount(),
                'baseSalaryCurrency' => $employee->getBaseSalary()->getCurrency()->value,
            ];
        }

        return $data;
    }
}
