<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomRules\Sniffs\Strings;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

final class ConcatenationSniff implements Sniff
{

    private const CONTENT = 'content';
    private const __DIR__ = '__DIR__';

    /**
     * @var string[]
     */
    public array $start = [
        self::__DIR__,
    ];

    /**
     * @var string[]
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

    public function process(File $file, mixed $position): int
    {
        $start = $file->getTokens()[$position + 2][self::CONTENT];
        $close = $file->getTokens()[$position - 2][self::CONTENT];

        if (!in_array($close, $this->start, TRUE) && !in_array($start, $this->close, TRUE)) {
            $file->addError('Usage of string concatenation operator is not allowed.', $position, 'Concatenation');
        }

        return 0;
    }

}
