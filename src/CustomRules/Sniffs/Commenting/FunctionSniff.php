<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomRules\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;

/**
 * Class FunctionSniff
 *
 * @package Bruha\CodingStandard\CustomRules\Sniffs\Commenting
 */
final class FunctionSniff extends AbstractSniff
{

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_OPEN_TAG];
    }

    /**
     * @param File  $file
     * @param mixed $position
     *
     * @return int|void
     */
    public function process(File $file, $position)
    {
        $tokens   = $file->getTokens();
        $position = $file->findNext([T_DOC_COMMENT_STRING], $position);

        while (is_int($position)) {
            $content = $tokens[$position]['content'];

            if (preg_match('#(\|null|null\||NULL\|)#', $content) === 1) {
                $file->addError(
                    'Parameter must have NULL type hint on last position.',
                    $position,
                    'Comment'
                );
            }

            $position = $file->findNext([T_DOC_COMMENT_STRING], $position + 1);
        }
    }

}