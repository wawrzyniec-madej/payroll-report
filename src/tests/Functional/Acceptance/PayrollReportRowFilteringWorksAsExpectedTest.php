<?php

namespace App\Tests\Functional\Acceptance;

use App\Tests\Helper\ApiTestCase;
use Generator;

final class PayrollReportRowFilteringWorksAsExpectedTest extends ApiTestCase
{
    private static string $generatedReportId;

    /** @dataProvider sortingDataProvider */
    public function test_sorting_works(string $filters, array $expectedResults): void
    {
        if (!isset(self::$generatedReportId)) {
            $this->client->request(
                'POST',
                '/payroll-report/generate'
            );

            self::$generatedReportId = $this->getJsonResponseData()['result'];
        }

        $this->client->request(
            'GET',
            sprintf(
                '/payroll-report/%s/rows?%s',
                self::$generatedReportId,
                $filters
            )
        );

        $this->assertEquals(
            [
                'result' => $expectedResults
            ],
            $this->getJsonResponseData()
        );
    }

    public function sortingDataProvider(): Generator
    {
        yield [
            'name=adam',
            [
                [
                    'name' => 'Adam',
                    'surname' => 'Kowalski',
                    'department' => 'HR',
                    'bonusType' => 'seniority',
                    'remunerationBase' => 100000,
                    'additionToBase' => 100000,
                    'salaryWithBonus' => 200000
                ]
            ]
        ];

        yield [
            'surname=Nowak',
            [
                [
                    'name' => 'Ania',
                    'surname' => 'Nowak',
                    'department' => 'Customer Service',
                    'bonusType' => 'percentage',
                    'remunerationBase' => 110000,
                    'additionToBase' => 11000,
                    'salaryWithBonus' => 121000
                ]
            ]
        ];

        yield [
            'department=hr',
            [
                [
                    'name' => 'Adam',
                    'surname' => 'Kowalski',
                    'department' => 'HR',
                    'bonusType' => 'seniority',
                    'remunerationBase' => 100000,
                    'additionToBase' => 100000,
                    'salaryWithBonus' => 200000
                ]
            ]
        ];

        yield [
            'department=Customer Service',
            [
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
        ];
    }
}