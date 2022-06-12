<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Functions\Data;

/**
 * Class TestSniffMissingTest
 *
 * @package Tests\Integration\CustomRules\Sniffs\Functions\Data
 */
final class TestSniffMissingTest
{

    /**
     *
     */
    public function testString(): void
    {
        $this->prepareData();
    }

    /**
     * @covers TestSniffMissingTest::prepareData
     */
    public function testInt(): void
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
