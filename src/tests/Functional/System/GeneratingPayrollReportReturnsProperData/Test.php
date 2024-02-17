<?php

namespace App\Tests\Functional\System\GeneratingPayrollReportReturnsProperData;

use App\Tests\Helper\ApiTestCase;

final class Test extends ApiTestCase
{
    public function test_returns_proper_data(): void
    {
        $this->client->request(
            'POST',
            '/payroll-report/generate'
        );

        $responseData = $this->getJsonResponseData();

        self::assertArrayHasKey('result', $responseData);

    }
}