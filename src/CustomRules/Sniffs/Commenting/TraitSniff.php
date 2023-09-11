<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomRules\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;

final class TraitSniff extends AbstractSniff
{

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_TRAIT];
    }

    public function process(File $file, mixed $position): int
    {
        $this->processCommenting($file, $position, self::TYPE_TRAIT);

        return 0;
    }

}
