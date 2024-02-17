<?php

namespace App\Module\PayrollReport\Infrastructure\EventListener;

use App\Module\PayrollReport\Domain\Event\PayrollReportGenerated;
use App\Module\PayrollReport\Domain\Interface\PayrollReportRepositoryInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
final readonly class PersistOnPayrollReportGeneratedListener
{
    public function __construct(
        private PayrollReportRepositoryInterface $payrollReportRepository
    ) {
    }

    public function __invoke(PayrollReportGenerated $event): void
    {
        $this->payrollReportRepository->save($event->getPayrollReport());
    }
}