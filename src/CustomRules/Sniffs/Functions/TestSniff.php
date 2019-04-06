<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomRules\Sniffs\Functions;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class TestSniff
 *
 * @package Bruha\CodingStandard\CustomRules\Sniffs\Functions
 */
final class TestSniff implements Sniff
{

    private const CODE    = 'code';
    private const CONTENT = 'content';

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_CLASS];
    }

    /**
     * @param File  $file
     * @param mixed $position
     *
     * @return int|void
     */
    public function process(File $file, $position)
    {
        $tokens        = $file->getTokens();
        $startPosition = (int) $position;

        if (substr($tokens[$position + 2][self::CONTENT], -4) === 'Test') {
            $position = $file->findNext(T_FUNCTION, $position + 1);
            $hasTests = TRUE;

            while (is_int($position)) {
                if ($tokens[$position - 2][self::CODE] === T_PUBLIC) {
                    if (substr($tokens[$position + 2][self::CONTENT], 0, 4) !== 'test') {
                        $hasTests = FALSE;
                    }
                }

                $position = $file->findNext(T_FUNCTION, $position + 1);
            }

            if ($hasTests && !is_int($file->findPrevious(T_FINAL, $startPosition))) {
                $file->addError('Usage of abstract or normal test class is not allowed.', $startPosition, 'Final');
            }
        }
    }

}