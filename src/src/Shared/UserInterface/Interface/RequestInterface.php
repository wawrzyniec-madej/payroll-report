<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\Interface;

use App\Shared\Application\FilterAndSort\Collection\FilterCollection;
use App\Shared\Application\FilterAndSort\Sort;
use Symfony\Component\HttpFoundation\Request;

interface RequestInterface
{
    public static function create(Request $request, FilterCollection $filters, ?Sort $sort): static;
}
