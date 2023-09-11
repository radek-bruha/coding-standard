<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomRules\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;

final class ClassSniff extends AbstractSniff
{

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_CLASS];
    }

    public function process(File $file, mixed $position): int
    {
        $this->processCommenting($file, $position, self::TYPE_CLASS);

        return 0;
    }

}
