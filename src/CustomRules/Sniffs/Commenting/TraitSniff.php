<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomRules\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;

/**
 * Class TraitSniff
 *
 * @package Bruha\CodingStandard\CustomRules\Sniffs\Commenting
 */
final class TraitSniff extends AbstractSniff
{

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_TRAIT];
    }

    /**
     * @param File  $file
     * @param mixed $position
     *
     * @return int
     */
    public function process(File $file, mixed $position): int
    {
        $this->processCommenting($file, $position, self::TYPE_TRAIT);

        return 0;
    }

}
