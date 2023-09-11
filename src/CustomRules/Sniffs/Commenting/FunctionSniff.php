<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomRules\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;

final class FunctionSniff extends AbstractSniff
{

    /**
     * @var string[]
     */
    public array $rules = ['#(?:\|NULL|null\||NULL\|)#' => 'Usage of non-rightmost null type hint is not allowed.'];

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_DOC_COMMENT_STRING];
    }

    public function process(File $file, mixed $position): int
    {
        foreach ($this->rules as $pattern => $message) {
            if (preg_match($pattern, $file->getTokens()[$position][self::CONTENT]) === 1) {
                $file->addError($message, $position, 'Comment');
            }
        }

        return 0;
    }

}
