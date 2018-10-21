<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomRules\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class ConstructorSniff
 *
 * @package Bruha\CodingStandard\CustomRules\Sniffs\Commenting
 */
final class ConstructorSniff extends AbstractSniff implements Sniff
{

    /**
     * @return array
     */
    public function register(): array
    {
        return [T_FUNCTION];
    }

    /**
     * @param File  $file
     * @param mixed $position
     *
     * @return int|void
     */
    public function process(File $file, $position)
    {
        $tokens = $file->getTokens();

        if ($tokens[$file->findNext([T_STRING], $position)]['content'] === '__construct') {
            $comments           = $this->getDocumentComment($file, $position);
            $constructorComment = sprintf('%s constructor', $this->getClassName($file, $position));
            $hasComment         = FALSE;

            foreach ($comments as $comment) {
                if ($comment === $constructorComment) {
                    $hasComment = TRUE;
                }
            }

            if (!$hasComment) {
                $file->addError(
                    sprintf("Constructor comment must be '%s'.", $constructorComment),
                    $position,
                    'Comment'
                );
            }
        }
    }

}