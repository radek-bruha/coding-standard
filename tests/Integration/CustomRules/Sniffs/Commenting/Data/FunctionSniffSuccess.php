<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Commenting\Data;

/**
 * Class FunctionSniffSuccess
 *
 * @package Tests\Integration\CustomRules\Sniffs\Commenting\Data
 */
final class FunctionSniffSuccess
{

    /**
     * @param string|null $stringOne
     * @param string|null $stringTwo
     * @param string|null $stringThree
     *
     * @return string|null
     */
    public function successNull(
        ?string $stringOne = NULL,
        ?string $stringTwo = NULL,
        ?string $stringThree = NULL
    ): ?string {
        return sprintf('%s %s %s', $stringOne, $stringTwo, $stringThree);
    }

}
