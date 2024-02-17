<?php

namespace App\Module\PayrollReport\UserInterface\View;

use App\Module\PayrollReport\Domain\Entity\PayrollReport;
use App\Shared\Domain\Exception\CollectionElementInvalidException;
use App\Shared\UserInterface\Collection\JsonSerializableCollection;

final readonly class PayrollReportView implements \JsonSerializable
{
    public function __construct(
        private PayrollReport $payrollReport
    ) {
    }

    /**
     * @return array{id: string, generationDate: string, rows: JsonSerializableCollection}
     * @throws CollectionElementInvalidException
     */
    public function jsonSerialize(): array
    {
        $rowViews = JsonSerializableCollection::createEmpty();
        foreach ($this->payrollReport->getRows() as $row) {
            $rowViews->add(
                new PayrollReportRowView($row)
            );
        }

        return [
            'id' => $this->payrollReport->getId()->getValue(),
            'generationDate' => $this->payrollReport->getGenerationDate()->toString(),
            'rows' => $rowViews,
        ];
    }
}
