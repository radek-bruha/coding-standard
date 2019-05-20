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
     * @var array
     */
    public $rules = ['#(\|null|null\||NULL\|)#' => 'Usage of non-rightmost NULL type hint is not allowed.'];

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_DOC_COMMENT_STRING];
    }

    /**
     * @param File  $file
     * @param mixed $position
     *
     * @return int|void
     */
    public function process(File $file, $position)
    {
        foreach ($this->rules as $pattern => $message) {
            if (preg_match($pattern, $file->getTokens()[$position][self::CONTENT]) === 1) {
                $file->addError($message, $position, 'Comment');
            }
        }
    }

}