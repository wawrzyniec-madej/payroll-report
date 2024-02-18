<?php

namespace App\Tests\Functional\Acceptance;

use App\Tests\Helper\ApiTestCase;

final class SearchPayrollReportRowsAllowsSortingTest extends ApiTestCase
{
    private static string $generatedReportId;

    /** @dataProvider sortingDataProvider */
    public function testSortingWorks(string $query, array $expectedResults): void
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
                $query
            )
        );

        $this->assertEquals(
            [
                'result' => $expectedResults,
            ],
            $this->getJsonResponseData()
        );
    }

    public function sortingDataProvider(): \Generator
    {
        yield [
            '',
            [
                [
                    'name' => 'Adam',
                    'surname' => 'Kowalski',
                    'department' => 'HR',
                    'bonusType' => 'seniority',
                    'remunerationBase' => 100000,
                    'additionToBase' => 100000,
                    'salaryWithBonus' => 200000,
                ],
                [
                    'name' => 'Ania',
                    'surname' => 'Nowak',
                    'department' => 'Customer Service',
                    'bonusType' => 'percentage',
                    'remunerationBase' => 110000,
                    'additionToBase' => 11000,
                    'salaryWithBonus' => 121000,
                ],
                [
                    'name' => 'Monika',
                    'surname' => 'Testowa',
                    'department' => 'Customer Service',
                    'bonusType' => 'percentage',
                    'remunerationBase' => 50000,
                    'additionToBase' => 5000,
                    'salaryWithBonus' => 55000,
                ],
            ],
        ];

        yield [
            'sort[name]=desc',
            [
                [
                    'name' => 'Monika',
                    'surname' => 'Testowa',
                    'department' => 'Customer Service',
                    'bonusType' => 'percentage',
                    'remunerationBase' => 50000,
                    'additionToBase' => 5000,
                    'salaryWithBonus' => 55000,
                ],
                [
                    'name' => 'Ania',
                    'surname' => 'Nowak',
                    'department' => 'Customer Service',
                    'bonusType' => 'percentage',
                    'remunerationBase' => 110000,
                    'additionToBase' => 11000,
                    'salaryWithBonus' => 121000,
                ],
                [
                    'name' => 'Adam',
                    'surname' => 'Kowalski',
                    'department' => 'HR',
                    'bonusType' => 'seniority',
                    'remunerationBase' => 100000,
                    'additionToBase' => 100000,
                    'salaryWithBonus' => 200000,
                ],
            ],
        ];

        yield [
            'sort[remunerationBase]=asc',
            [
                [
                    'name' => 'Monika',
                    'surname' => 'Testowa',
                    'department' => 'Customer Service',
                    'bonusType' => 'percentage',
                    'remunerationBase' => 50000,
                    'additionToBase' => 5000,
                    'salaryWithBonus' => 55000,
                ],
                [
                    'name' => 'Adam',
                    'surname' => 'Kowalski',
                    'department' => 'HR',
                    'bonusType' => 'seniority',
                    'remunerationBase' => 100000,
                    'additionToBase' => 100000,
                    'salaryWithBonus' => 200000,
                ],
                [
                    'name' => 'Ania',
                    'surname' => 'Nowak',
                    'department' => 'Customer Service',
                    'bonusType' => 'percentage',
                    'remunerationBase' => 110000,
                    'additionToBase' => 11000,
                    'salaryWithBonus' => 121000,
                ],
            ],
        ];
    }
}
