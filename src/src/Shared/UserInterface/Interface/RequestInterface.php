<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\Interface;

use App\Shared\UserInterface\Factory\FilterFactory;
use App\Shared\UserInterface\Factory\SortFactory;
use Symfony\Component\HttpFoundation\Request;

interface RequestInterface
{
    public static function create(Request $request, FilterFactory $filterFactory, SortFactory $sortFactory): static;
}
