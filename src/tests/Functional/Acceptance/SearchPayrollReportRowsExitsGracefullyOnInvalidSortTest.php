<?php

declare(strict_types=1);

use App\Tests\Helper\ApiTestCase;

final class SearchPayrollReportRowsExitsGracefullyOnInvalidSortTest extends ApiTestCase
{
    public function testSuccess(): void
    {
        $this->client->request(
            'GET',
            '/payroll-report/some-id/rows?sort[name]=invalid_criterion'
        );

        self::assertResponseStatusCodeSame(400);
        self::assertEquals(
            [
                'message' => 'Sort [name] with value [invalid_criterion] is invalid.',
            ],
            $this->getJsonResponseData()
        );
    }
}
