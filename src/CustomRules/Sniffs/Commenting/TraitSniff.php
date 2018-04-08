<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomRules\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;

/**
 * Class TraitSniff
 *
 * @package Bruha\CodingStandard\CustomRules\Sniffs\Commenting
 */
final class TraitSniff extends AbstractSniff
{

    /**
     * @return array
     */
    public function register(): array
    {
        return [T_TRAIT];
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
        $traitComment     = sprintf('Trait %s', $tokens[$position]['content']);
        $namespaceComment = $this->getNamespaceName($file, $position);

        $hasComment = FALSE;
        foreach ($comments as $comment) {
            if ($comment === $traitComment) {
                $hasComment = TRUE;
            }
        }

        if (!$hasComment) {
            $file->addError(
                sprintf("Trait comment must be '%s'.", $traitComment),
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
                sprintf("Trait comment must be '@package %s'.", $namespaceComment),
                $position,
                'Comment'
            );
        }
    }

}