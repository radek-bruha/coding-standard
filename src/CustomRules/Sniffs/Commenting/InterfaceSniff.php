<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomRules\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;

/**
 * Class InterfaceSniff
 *
 * @package Bruha\CodingStandard\CustomRules\Sniffs\Commenting
 */
final class InterfaceSniff extends AbstractSniff
{

    /**
     * @return array
     */
    public function register(): array
    {
        return [T_INTERFACE];
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
        /** @var int $position */
        $position = $file->findNext([T_STRING], $position);

        $comments         = $this->getDocumentComment($file, $position);
        $interfaceComment = sprintf('Interface %s', $tokens[$position]['content']);
        $namespaceComment = $this->getNamespaceName($file, $position);
        $hasComment       = FALSE;

        foreach ($comments as $comment) {
            if ($comment === $interfaceComment) {
                $hasComment = TRUE;
            }
        }

        if (!$hasComment) {
            $file->addError(
                sprintf("Interface comment must be '%s'.", $interfaceComment),
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
                sprintf("Interface comment must be '@package %s'.", $namespaceComment),
                $position,
                'Comment'
            );
        }
    }

}