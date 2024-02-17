<?php

namespace App\Tests\Functional\Acceptance;

use App\Tests\Helper\ApiTestCase;

final class PayrollReportGenerationProcessWorksAsExpectedTest extends ApiTestCase
{
    public function testGenerateReturnsProperData(): string
    {
        $this->client->request(
            'POST',
            '/payroll-report/generate'
        );

        $responseData = $this->getJsonResponseData();

        self::assertArrayHasKey('result', $responseData);
        self::assertNotNull($responseData['result']);

        return $responseData['result'];
    }

    /** @depends testGenerateReturnsProperData */
    public function testGetReturnsProperData(string $generatedReportIdentifier): void
    {
        $this->client->request(
            'GET',
            '/payroll-report/' . $generatedReportIdentifier . '/rows'
        );

        $this->assertEquals(
            [
                'result' => [
                    [
                        'name' => 'Adam',
                        'surname' => 'Kowalski',
                        'department' => 'HR',
                        'bonusType' => 'seniority',
                        'remunerationBase' => 100000,
                        'additionToBase' => 100000,
                        'salaryWithBonus' => 200000
                    ],
                    [
                        'name' => 'Ania',
                        'surname' => 'Nowak',
                        'department' => 'Customer Service',
                        'bonusType' => 'percentage',
                        'remunerationBase' => 110000,
                        'additionToBase' => 11000,
                        'salaryWithBonus' => 121000
                    ],
                    [
                        'name' => 'Monika',
                        'surname' => 'Testowa',
                        'department' => 'Customer Service',
                        'bonusType' => 'percentage',
                        'remunerationBase' => 50000,
                        'additionToBase' => 5000,
                        'salaryWithBonus' => 55000
                    ]
                ]
            ],
            $this->getJsonResponseData()
        );
    }
}
