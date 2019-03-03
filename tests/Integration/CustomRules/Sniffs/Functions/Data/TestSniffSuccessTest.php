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
     *
     */
    public function testString(): void
    {
        $this->prepareData();
    }

    /**
     * @return array
     */
    private function prepareData(): array
    {
        return [];
    }

}