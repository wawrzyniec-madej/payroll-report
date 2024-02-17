<?php

namespace App\Module\PayrollReport\UserInterface\Request;

use App\Shared\Application\FilterAndSort\Collection\FilterCollection;
use App\Shared\Application\FilterAndSort\Collection\FilterNameCollection;
use App\Shared\Application\FilterAndSort\Collection\SortNameCollection;
use App\Shared\Application\FilterAndSort\FilterName;
use App\Shared\Application\FilterAndSort\Sort;
use App\Shared\Application\FilterAndSort\SortName;
use App\Shared\Domain\ValueObject\Identifier;
use App\Shared\UserInterface\Interface\FilterableRequestInterface;
use App\Shared\UserInterface\Interface\SortableRequestInterface;
use App\Shared\UserInterface\Request\AbstractRequest;

final readonly class GetPayrollReportRequest extends AbstractRequest implements FilterableRequestInterface, SortableRequestInterface
{
    public function getId(): Identifier
    {
        return new Identifier($this->request->attributes->get('id'));
    }

    public static function getAllowedFilterNames(): FilterNameCollection
    {
        return FilterNameCollection::createFromSpread(
            new FilterName('department'),
            new FilterName('name'),
            new FilterName('surname'),
        );
    }

    public static function getAllowedSortNames(): SortNameCollection
    {
        return SortNameCollection::createFromSpread(
            new SortName('name'),
            new SortName('surname'),
            new SortName('department'),
            new SortName('remunerationBase'),
            new SortName('additionToBase'),
            new SortName('bonusType'),
            new SortName('salaryWithBonus'),
        );
    }

    public function getFilters(): FilterCollection
    {
        return $this->filters;
    }

    public function getSort(): ?Sort
    {
        return $this->sort;
    }
}