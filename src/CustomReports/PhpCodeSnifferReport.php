<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomReports;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Reports\Report;

final class PhpCodeSnifferReport implements Report
{

    private string $root;

    public function __construct()
    {
        $this->root = sprintf('%s/', getcwd());
    }

    /**
     * @param mixed[] $report
     */
    public function generateFileReport(
        mixed $report,
        File $phpcsFile,
        mixed $showSources = FALSE,
        mixed $width = 80,
    ): bool {
        if (count($report['messages']) > 0) {
            $path = str_replace($this->root, '', $report['filename']);

            foreach ($report['messages'] as $rowNumber => $rows) {
                foreach ($rows as $cols) {
                    foreach ($cols as $message) {
                        echo sprintf('%s:%s: %s%s', $path, $rowNumber, $message['message'], PHP_EOL);
                    }
                }
            }
        }

        return TRUE;
    }

    public function generate(
        mixed $cachedData,
        mixed $totalFiles,
        mixed $totalErrors,
        mixed $totalWarnings,
        mixed $totalFixable,
        mixed $showSources = FALSE,
        mixed $width = 80,
        mixed $interactive = FALSE,
        mixed $toScreen = TRUE,
    ): void {
        if (strlen($cachedData) !== 0) {
            echo sprintf('%s%sErrors: %s%s', $cachedData, PHP_EOL, $totalErrors, PHP_EOL);
        }
    }

}
