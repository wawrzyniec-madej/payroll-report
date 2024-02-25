<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\UserInterface\Controller;

use App\Module\PayrollReport\Application\Command\GeneratePayrollReportCommand;
use App\Module\PayrollReport\Domain\Exception\CannotCalculateBonusDetailsException;
use App\Module\PayrollReport\Domain\Exception\CannotGetDepartmentException;
use App\Module\PayrollReport\Domain\Exception\InvalidYearsOfSeniorityException;
use App\Module\PayrollReport\UserInterface\View\IdentifierView;
use App\Shared\Domain\Exception\IncompatibleMoneyException;
use App\Shared\Domain\Exception\InvalidDateTimeException;
use App\Shared\UserInterface\Response\ResultResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final readonly class GeneratePayrollReportController
{
    public function __construct(
        private GeneratePayrollReportCommand $generatePayrollReportCommand
    ) {
    }

    #[Route(path: '/payroll-report/generate', methods: [Request::METHOD_POST])]
    public function __invoke(): ResultResponse
    {
        $payrollReportIdentifier = $this->generatePayrollReportCommand->generate();

        return new ResultResponse(new IdentifierView($payrollReportIdentifier));
    }
}
