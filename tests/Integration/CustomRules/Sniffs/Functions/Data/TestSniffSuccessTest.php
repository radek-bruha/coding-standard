<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Functions\Data;

/**
 * Class TestSniffSuccessTest
 *
 * @package Tests\Integration\CustomRules\Sniffs\Functions\Data
 */
final class TestSniffSuccessTest
{

    /**
     * @param string $string
     *
     * @return string
     */
    public function processString(string $string): string
    {
        return $string;
    }

    /**
     * @covers \Tests\Integration\CustomRules\Sniffs\Functions\Data\TestSniffSuccessTest::prepareData
     */
    public function testString(): void
    {
        $this->prepareData();
    }

    /**
     * @return mixed[]
     */
    private function prepareData(): array
    {
        return [];
    }

}
