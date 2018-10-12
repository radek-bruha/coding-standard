<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Commenting\Data;

/**
 * Class FunctionSniffMissing
 *
 * @package Tests\Integration\CustomRules\Sniffs\Commenting\Data
 */
class FunctionSniffMissing
{

    /**
     * @param null|string $stringOne
     * @param string|null $stringTwo
     * @param NULL|string $stringThree
     *
     * @return string|NULL
     */
    public function missingNull(
        ?string $stringOne = NULL,
        ?string $stringTwo = NULL,
        ?string $stringThree = NULL
    ): ?string {
        return sprintf('%s %s %s', $stringOne, $stringTwo, $stringThree);
    }

}