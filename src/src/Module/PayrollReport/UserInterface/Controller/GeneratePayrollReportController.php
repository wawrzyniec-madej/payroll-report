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
use App\Shared\UserInterface\Response\SuccessResponse;
use App\Shared\UserInterface\View\ResultView;
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

    /**
     * @throws CannotCalculateBonusDetailsException
     * @throws InvalidYearsOfSeniorityException
     * @throws IncompatibleMoneyException
     * @throws CannotGetDepartmentException
     * @throws InvalidDateTimeException
     */
    #[Route(path: '/payroll-report/generate', methods: [Request::METHOD_POST])]
    public function __invoke(): SuccessResponse
    {
        $payrollReportIdentifier = $this->generatePayrollReportCommand->generate();

        return new SuccessResponse(
            new ResultView(
                new IdentifierView($payrollReportIdentifier)
            )
        );
    }
}
