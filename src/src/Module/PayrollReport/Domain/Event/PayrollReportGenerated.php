<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Domain\Event;

use App\Module\PayrollReport\Domain\Entity\PayrollReport;
use App\Shared\Domain\Interface\DomainEventInterface;
use DateTimeImmutable;

final readonly class PayrollReportGenerated implements DomainEventInterface
{
    private function __construct(
        private DateTimeImmutable $occurredAt,
        private PayrollReport $payrollReport
    ) {
    }

    public static function create(PayrollReport $payrollReport): self
    {
        return new self(
            new DateTimeImmutable(),
            $payrollReport
        );
    }

    public function getPayrollReport(): PayrollReport
    {
        return $this->payrollReport;
    }

    public function getOccurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
