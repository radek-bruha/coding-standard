<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Commenting\Data;

/**
 * Class FunctionSniffSuccess
 *
 * @package Tests\Integration\CustomRules\Sniffs\Commenting\Data
 */
class FunctionSniffSuccess
{

    /**
     * @param string|NULL $stringOne
     * @param string|NULL $stringTwo
     * @param string|NULL $stringThree
     *
     * @return string|NULL
     */
    public function successNull(
        ?string $stringOne = NULL,
        ?string $stringTwo = NULL,
        ?string $stringThree = NULL
    ): ?string {
        return sprintf('%s %s %s', $stringOne, $stringTwo, $stringThree);
    }

}