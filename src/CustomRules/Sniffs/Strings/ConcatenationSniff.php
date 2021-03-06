<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomRules\Sniffs\Strings;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class ConcatenationSniff
 *
 * @package Bruha\CodingStandard\CustomRules\Sniffs\Strings
 */
final class ConcatenationSniff implements Sniff
{

    private const CONTENT = 'content';
    private const __DIR__ = '__DIR__';

    /**
     * @var mixed[]
     */
    public array $start = [
        self::__DIR__,
    ];

    /**
     * @var mixed[]
     */
    public array $close = [
        self::__DIR__,
    ];

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_STRING_CONCAT];
    }

    /**
     * @param File  $file
     * @param mixed $position
     *
     * @return int
     */
    public function process(File $file, $position): int
    {
        $start = $file->getTokens()[$position + 2][self::CONTENT];
        $close = $file->getTokens()[$position - 2][self::CONTENT];

        if (!in_array($close, $this->start, TRUE) && !in_array($start, $this->close, TRUE)) {
            $file->addError('Usage of string concatenation operator is not allowed.', $position, 'Concatenation');
        }

        return 0;
    }

}