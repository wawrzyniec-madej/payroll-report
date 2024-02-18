<?php

namespace App\Module\Department\UserInterface\PrimaryAdapter;

use App\Module\Department\Application\Query\GetDepartmentByIdQuery;
use App\Module\Department\Domain\Exception\DepartmentNotFoundException;
use App\Shared\Domain\ValueObject\Identifier;

final readonly class GetDepartmentByIdAdapter
{
    public function __construct(
        private GetDepartmentByIdQuery $getDepartmentByIdQuery
    ) {
    }

    /**
     * @return array{name: string, bonusId: string}
     * @throws DepartmentNotFoundException
     */
    public function get(string $id): array
    {
        $department = $this->getDepartmentByIdQuery->get(
            new Identifier($id)
        );

        return [
            'name' => $department->getName()->getValue(),
            'bonusId' => $department->getBonusId()->getValue(),
        ];
    }
}
