<?php

namespace App\Module\Employee\Infrastructure\Repository;

use App\Module\Employee\Domain\Entity\Employee;
use App\Module\Employee\Domain\Interface\EmployeeRepositoryInterface;
use App\Module\Employee\Domain\ValueObject\BaseSalary;
use App\Module\Employee\Domain\ValueObject\DateOfEmployment;
use App\Module\Employee\Domain\ValueObject\Name;
use App\Module\Employee\Domain\ValueObject\Surname;
use App\Shared\Domain\Enum\CurrencyEnum;
use App\Shared\Domain\Interface\IdentifierGeneratorInterface;
use App\Shared\Domain\ValueObject\Identifier;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;

final class DbalEmployeeRepository implements EmployeeRepositoryInterface
{
    public function __construct(
        private readonly Connection $connection,
        private readonly IdentifierGeneratorInterface $identifierGenerator
    ) {
    }

    public function getOneById(Identifier $identifier): Employee
    {
        return Employee::recreate(
            $identifier,
            new Name('Sara'),
            new Surname('Konor'),
            new DateOfEmployment(new DateTimeImmutable('2021-01-02 06:00:00')),
            $this->identifierGenerator->generate(),
            new BaseSalary(1000, CurrencyEnum::USD)
        );
    }
}