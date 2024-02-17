<?php

namespace App\Tests\Functional\Acceptance;

use App\Tests\Helper\ApiTestCase;
use App\Tests\Helper\ArrayChecker\ArrayChecker;
use App\Tests\Helper\ArrayChecker\IsTypeCheck;

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
            '/payroll-report/'.$generatedReportIdentifier
        );

        $responseData = $this->getJsonResponseData();

        $checker = new ArrayChecker(
            [
                'result' => [
                    'id' => $generatedReportIdentifier,
                    'generationDate' => new IsTypeCheck('string'),
                    'rows' => [
                        [
                            'id' => new IsTypeCheck('string'),
                            'employee' => [
                                'name' => 'Adam',
                                'surname' => 'Kowalski',
                            ],
                            'bonusType' => 'seniority',
                            'remunerationBase' => [
                                'amount' => 100000,
                                'currency' => 'usd',
                            ],
                            'additionToBase' => [
                                'amount' => 100000,
                                'currency' => 'usd',
                            ],
                            'salaryWithBonus' => [
                                'amount' => 200000,
                                'currency' => 'usd',
                            ],
                        ],
                        [
                            'id' => new IsTypeCheck('string'),
                            'employee' => [
                                'name' => 'Ania',
                                'surname' => 'Nowak',
                            ],
                            'bonusType' => 'percentage',
                            'remunerationBase' => [
                                'amount' => 110000,
                                'currency' => 'usd',
                            ],
                            'additionToBase' => [
                                'amount' => 11000,
                                'currency' => 'usd',
                            ],
                            'salaryWithBonus' => [
                                'amount' => 121000,
                                'currency' => 'usd',
                            ],
                        ],
                    ],
                ],
            ]
        );

        $checker->checkData($responseData);
    }
}
