<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Functions\Data;

/**
 * Class TestSniffMissingTest
 *
 * @package Tests\Integration\CustomRules\Sniffs\Functions\Data
 */
class TestSniffMissingTest
{

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