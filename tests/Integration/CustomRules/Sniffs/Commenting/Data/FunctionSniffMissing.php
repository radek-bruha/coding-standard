<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Commenting\Data;

/**
 * Class FunctionSniffMissing
 *
 * @package Tests\Integration\CustomRules\Sniffs\Commenting\Data
 */
final class FunctionSniffMissing
{

    /**
     * @param null|string $stringOne
     * @param string|NULL $stringTwo
     * @param NULL|string $stringThree
     *
     * @return string|null
     */
    public function missingNull(
        ?string $stringOne = NULL,
        ?string $stringTwo = NULL,
        ?string $stringThree = NULL
    ): ?string {
        return sprintf('%s %s %s', $stringOne, $stringTwo, $stringThree);
    }

}