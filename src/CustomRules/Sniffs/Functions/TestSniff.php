<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomRules\Sniffs\Functions;

use Bruha\CodingStandard\CustomRules\Sniffs\Commenting\AbstractSniff;
use PHP_CodeSniffer\Files\File;

/**
 * Class TestSniff
 *
 * @package Bruha\CodingStandard\CustomRules\Sniffs\Functions
 */
final class TestSniff extends AbstractSniff
{

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_CLASS];
    }

    /**
     * @param File  $file
     * @param mixed $position
     *
     * @return int
     */
    public function process(File $file, mixed $position): int
    {
        $tokens      = $file->getTokens();
        $coverages   = [];
        $annotations = [];

        if (substr($tokens[$position + 2][self::CONTENT], -4) === 'Test') {
            $position = $file->findNext(T_FUNCTION, $position + 1);
            $hasTests = TRUE;

            while (is_int($position)) {
                if ($tokens[$position - 2][self::CODE] === T_PUBLIC) {
                    if (substr($tokens[$position + 2][self::CONTENT], 0, 4) !== 'test') {
                        $hasTests = FALSE;
                    } else {
                        $innerPosition = $file->findPrevious(T_DOC_COMMENT_OPEN_TAG, $position);

                        if (is_int($innerPosition)) {
                            $hasCoverage = FALSE;

                            foreach ($this->getDocumentComment($file, $innerPosition) as $comment) {
                                if (strpos($comment, '@covers') !== FALSE) {
                                    $hasCoverage         = TRUE;
                                    $hasNotNamespace     = strpos($comment, '\\') === FALSE;
                                    $hasNotCoversNothing = strpos($comment, '@coversNothing') === FALSE;

                                    if ($hasNotNamespace && $hasNotCoversNothing) {
                                        $annotations[] = $innerPosition;
                                    }
                                }
                            }

                            if (!$hasCoverage) {
                                $coverages[] = $innerPosition;
                            }
                        }
                    }
                }

                $position = $file->findNext(T_FUNCTION, $position + 1);
            }

            if ($hasTests) {
                foreach ($coverages as $coverage) {
                    $file->addError(
                        'Usage of test method without @covers annotation is not allowed.',
                        $coverage,
                        'Covers',
                    );
                }

                foreach ($annotations as $annotation) {
                    $file->addError(
                        'Usage of @covers annotation without namespace is not allowed.',
                        $annotation,
                        'Covers',
                    );
                }
            }
        }

        return 0;
    }

}
