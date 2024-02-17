<?php

namespace App\Module\Employee\Infrastructure\Repository;

use App\Module\Employee\Domain\Collection\EmployeeCollection;
use App\Module\Employee\Domain\Entity\Employee;
use App\Module\Employee\Domain\Interface\EmployeeRepositoryInterface;
use App\Module\Employee\Domain\ValueObject\Name;
use App\Module\Employee\Domain\ValueObject\Surname;
use App\Shared\Domain\DateTime;
use App\Shared\Domain\Enum\CurrencyEnum;
use App\Shared\Domain\ValueObject\Identifier;
use App\Shared\Domain\ValueObject\Money;
use App\Shared\Infrastructure\Exception\DatabaseException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final readonly class DbalEmployeeRepository implements EmployeeRepositoryInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function getAll(): EmployeeCollection
    {
        $builder = $this->connection->createQueryBuilder();

        $builder
            ->select('e.*')
            ->from('employee', 'e');

        try {
            /** @var list<array{id:string, name:string, surname:string, date_of_employment:string, department_id:string, base_salary_amount:int, base_salary_currency:string}> $results */
            $results = $builder->fetchAllAssociative();
        } catch (Exception $exception) {
            throw DatabaseException::fromPrevious($exception);
        }

        $employees = EmployeeCollection::createEmpty();
        foreach ($results as $result) {
            $employees->add(
                Employee::recreate(
                    new Identifier($result['id']),
                    new Name($result['name']),
                    new Surname($result['surname']),
                    DateTime::recreate($result['date_of_employment']),
                    new Identifier($result['department_id']),
                    new Money(
                        $result['base_salary_amount'],
                        CurrencyEnum::from($result['base_salary_currency'])
                    )
                )
            );
        }

        return $employees;
    }
}
