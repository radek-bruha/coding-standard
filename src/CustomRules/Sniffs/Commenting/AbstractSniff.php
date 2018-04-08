<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomRules\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;

/**
 * Class AbstractSniff
 *
 * @package Bruha\CodingStandard\CustomRules\Sniffs\Commenting
 */
abstract class AbstractSniff
{

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
        $startPosition = $file->findPrevious([T_DOC_COMMENT_OPEN_TAG], $position);

        if ($startPosition) {
            $closePosition = $file->findNext([T_DOC_COMMENT_CLOSE_TAG], $startPosition);

            for (; $startPosition < $closePosition; $startPosition++) {
                if ($tokens[$startPosition]['type'] === 'T_DOC_COMMENT_STRING') {
                    $result[] = $tokens[$startPosition]['content'];
                }
            }
        }

        return $result;
    }

    /**
     * @param File $file
     * @param int  $position
     *
     * @return string
     */
    protected function getClassName(File $file, int $position): string
    {
        $position = $file->findPrevious([T_CLASS], $position);

        if ($position) {
            $position = $file->findNext([T_STRING], $position);

            if ($position) {
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

        $position = $file->findPrevious([T_NAMESPACE], $position);

        if ($position) {
            $position = $file->findNext([T_STRING], $position);

            if ($position) {
                $closePosition = $file->findEndOfStatement($position);

                for (; $position < $closePosition; $position++) {
                    $namespaces[] = $tokens[$position]['content'];
                }

                $result = implode('', $namespaces);
            }
        }

        return $result;
    }

}