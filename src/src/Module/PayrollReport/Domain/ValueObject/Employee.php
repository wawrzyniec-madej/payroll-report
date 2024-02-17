<?php

namespace App\Module\PayrollReport\Domain\ValueObject;

final readonly class Employee
{
    public function __construct(
        private Name $name,
        private Surname $surname,
        private RemunerationBase $remunerationBase,
        private Department $department
    ) {
    }

    public function getSurname(): Surname
    {
        return $this->surname;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getRemunerationBase(): RemunerationBase
    {
        return $this->remunerationBase;
    }

    public function getDepartment(): Department
    {
        return $this->department;
    }
}