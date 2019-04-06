<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomRules\Sniffs\Functions;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class ParentSniff
 *
 * @package Bruha\CodingStandard\CustomRules\Sniffs\Functions
 */
final class ParentSniff implements Sniff
{

    private const CODE    = 'code';
    private const CONTENT = 'content';
    private const PATTERN = '#\r\n|\r|\n#';

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_PARENT];
    }

    /**
     * @param File  $file
     * @param mixed $position
     *
     * @return int|void
     */
    public function process(File $file, $position)
    {
        $startPosition = (int) $file->findNext(T_SEMICOLON, $position);
        $closePosition = $file->findNext(T_SEMICOLON, $startPosition + 1);

        if (is_int($closePosition) && $closePosition === $file->findEndOfStatement($startPosition)) {
            for ($iterator = 1; $iterator < 3; $iterator++) {
                $token = $file->getTokens()[$startPosition + $iterator];

                if ($token[self::CODE] !== T_WHITESPACE || preg_match(self::PATTERN, $token[self::CONTENT]) === 0) {
                    $file->addError('Usage of parent call without single blank line is not allowed.', $position, 'NewLine');
                }
            }
        }
    }

}