<?php

namespace App\Tests\Helper\ArrayChecker;

final readonly class ArrayChecker
{
    public function __construct(
        private array $expectation
    ) {
    }

    /** @throws CheckFailedException */
    public function checkData(array $data): void
    {
        $this->compareArrays(
            $this->expectation,
            $data
        );
    }

    private function compareArrays(array $expectation, array $data, string $parentKey = ''): void
    {
        foreach ($expectation as $key => $value) {
            $currentKey = $parentKey.$key;

            if (array_key_exists($key, $data)) {
                if (is_array($value)) {
                    $this->compareArrays($value, $data[$key], $currentKey.'.');
                } else {
                    $expectedValue = $data[$key];

                    $check = $value instanceof CheckInterface
                        ? $value
                        : new IsEqualCheck($value);

                    $check->check($expectedValue, $currentKey);
                }
            } else {
                throw CheckFailedException::create(sprintf('Key [%s] is missing from expected data.', $currentKey));
            }
        }
    }
}
