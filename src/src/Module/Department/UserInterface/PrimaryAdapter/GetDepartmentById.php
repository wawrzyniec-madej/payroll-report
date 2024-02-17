<?php

namespace App\Module\Department\UserInterface\PrimaryAdapter;

use App\Module\Department\Application\Query\GetDepartmentByIdQuery;
use App\Shared\Domain\ValueObject\Identifier;

final class GetDepartmentById
{
    public function __construct(
        private readonly GetDepartmentByIdQuery $getDepartmentByIdQuery
    ) {
    }

    /** @return array{name: string, bonusId: string} */
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
