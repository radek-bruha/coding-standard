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
        $tokens        = $file->getTokens();
        $startPosition = $file->findNext(T_SEMICOLON, $position);
        $closePosition = $file->findNext(T_CLOSE_CURLY_BRACKET, $position);

        if (is_int($startPosition) && is_int($closePosition)) {
            $semicolonPosition = $file->findNext(T_SEMICOLON, $startPosition + 1);

            if (is_int($semicolonPosition) && $semicolonPosition < $closePosition) {
                for ($iterator = 1; $iterator < 3; $iterator++) {
                    $token = $tokens[$startPosition + $iterator];

                    if ($token['type'] !== 'T_WHITESPACE' || preg_match('/\r\n|\r|\n/', $token['content']) === 0) {
                        $file->addError(
                            'Parent call must be followed by single blank line.',
                            $position,
                            'NewLine'
                        );
                    }
                }
            }
        }
    }

}