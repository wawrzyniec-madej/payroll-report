<?php

namespace App\Module\Employee\Domain\Entity;

use App\Module\Employee\Domain\ValueObject\BaseSalary;
use App\Module\Employee\Domain\ValueObject\DateOfEmployment;
use App\Module\Employee\Domain\ValueObject\Name;
use App\Module\Employee\Domain\ValueObject\Surname;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\ValueObject\Identifier;

final class Employee extends AggregateRoot
{
    private function __construct(
        private readonly Identifier $id,
        private readonly Name $name,
        private readonly Surname $surname,
        private readonly DateOfEmployment $dateOfEmployment,
        private readonly Identifier $departmentId,
        private readonly BaseSalary $baseSalary
    ) {
    }

    public static function recreate(
        Identifier $id,
        Name $name,
        Surname $surname,
        DateOfEmployment $dateOfEmployment,
        Identifier $departmentId,
        BaseSalary $baseSalary
    ): self {
        return new self($id, $name, $surname, $dateOfEmployment, $departmentId, $baseSalary);
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getSurname(): Surname
    {
        return $this->surname;
    }

    public function getId(): Identifier
    {
        return $this->id;
    }

    public function getDateOfEmployment(): DateOfEmployment
    {
        return $this->dateOfEmployment;
    }

    public function getDepartmentId(): Identifier
    {
        return $this->departmentId;
    }

    public function getBaseSalary(): BaseSalary
    {
        return $this->baseSalary;
    }
}