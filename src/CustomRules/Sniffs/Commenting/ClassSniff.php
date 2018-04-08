<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomRules\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;

/**
 * Class ClassSniff
 *
 * @package Bruha\CodingStandard\CustomRules\Sniffs\Commenting
 */
final class ClassSniff extends AbstractSniff
{

    /**
     * @return array
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
        $tokens   = $file->getTokens();
        $position = $file->findNext([T_STRING], $position);

        $comments         = $this->getDocumentComment($file, $position);
        $classComment     = sprintf('Class %s', $tokens[$position]['content']);
        $namespaceComment = $this->getNamespaceName($file, $position);

        $hasComment = FALSE;
        foreach ($comments as $comment) {
            if ($comment === $classComment) {
                $hasComment = TRUE;
            }
        }

        if (!$hasComment) {
            $file->addError(
                sprintf("Class comment must be '%s'.", $classComment),
                $position,
                'Comment'
            );
        }

        $hasComment = FALSE;
        foreach ($comments as $comment) {
            if ($comment === $namespaceComment) {
                $hasComment = TRUE;
            }
        }

        if (!$hasComment) {
            $file->addError(
                sprintf("Class comment must be '@package %s'.", $namespaceComment),
                $position,
                'Comment'
            );
        }
    }

}