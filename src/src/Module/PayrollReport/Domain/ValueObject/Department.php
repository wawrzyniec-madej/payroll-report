<?php

namespace App\Module\PayrollReport\Domain\ValueObject;

use App\Shared\Domain\ValueObject\Identifier;

final readonly class Department
{
    public function __construct(
        private DepartmentName $name,
        private Identifier $bonusId
    ) {
    }

    public function getName(): DepartmentName
    {
        return $this->name;
    }

    public function getBonusId(): Identifier
    {
        return $this->bonusId;
    }
}
