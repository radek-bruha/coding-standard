<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomRules\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class AbstractSniff
 *
 * @package Bruha\CodingStandard\CustomRules\Sniffs\Commenting
 */
abstract class AbstractSniff implements Sniff
{

    protected const TYPE_CLASS     = 'Class';
    protected const TYPE_INTERFACE = 'Interface';
    protected const TYPE_TRAIT     = 'Trait';

    /**
     * @param File $file
     * @param int  $position
     *
     * @return string
     */
    protected function getTypeName(File $file, int $position): string
    {
        $position = $file->findPrevious(T_CLASS, $position);

        if (is_int($position)) {
            $position = $file->findNext(T_STRING, $position);

            if (is_int($position)) {
                return $file->getTokens()[$position]['content'];
            }
        }

        return 'Unknown';
    }

    /**
     * @param File $file
     * @param int  $position
     *
     * @return string
     */
    protected function getNamespaceName(File $file, int $position): string
    {
        $result     = 'Unknown';
        $tokens     = $file->getTokens();
        $namespaces = [];

        $position = $file->findPrevious(T_NAMESPACE, $position);

        if (is_int($position)) {
            $position = $file->findNext(T_STRING, $position);

            if (is_int($position)) {
                $closePosition = $file->findEndOfStatement($position);

                for (; $position < $closePosition; $position++) {
                    $namespaces[] = $tokens[$position]['content'];
                }

                $result = implode('', $namespaces);
            }
        }

        return $result;
    }

    /**
     * @param File $file
     * @param int  $position
     *
     * @return array
     */
    protected function getDocumentComment(File $file, int $position): array
    {
        $result        = [];
        $tokens        = $file->getTokens();
        $startPosition = $file->findPrevious(T_DOC_COMMENT_OPEN_TAG, $position);

        if (is_int($startPosition)) {
            $closePosition = $file->findNext(T_DOC_COMMENT_CLOSE_TAG, $startPosition);

            for (; $startPosition < $closePosition; $startPosition++) {
                if ($tokens[$startPosition]['type'] === 'T_DOC_COMMENT_STRING') {
                    $result[] = $tokens[$startPosition]['content'];
                }
            }
        }

        return $result;
    }

    /**
     * @param File   $file
     * @param int    $position
     * @param string $type
     *
     * @return int|void
     */
    protected function processCommenting(File $file, int $position, string $type)
    {
        $tokens   = $file->getTokens();
        $position = $file->findNext(T_STRING, $position);

        if (is_int($position)) {
            $comments         = $this->getDocumentComment($file, $position);
            $typeComment      = sprintf('%s %s', $type, $tokens[$position]['content']);
            $namespaceComment = $this->getNamespaceName($file, $position);
            $hasComment       = FALSE;

            foreach ($comments as $comment) {
                if ($comment === $typeComment) {
                    $hasComment = TRUE;
                }
            }

            if (!$hasComment) {
                $file->addError(sprintf("%s comment must be '%s'.", $type, $typeComment), $position, 'Comment');
            }

            $hasComment = FALSE;

            foreach ($comments as $comment) {
                if ($comment === $namespaceComment) {
                    $hasComment = TRUE;
                }
            }

            if (!$hasComment) {
                $file->addError(
                    sprintf("%s comment must be '@package %s'.", $type, $namespaceComment),
                    $position,
                    'Comment'
                );
            }
        }
    }

}