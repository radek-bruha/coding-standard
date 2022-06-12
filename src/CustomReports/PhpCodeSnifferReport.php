<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomReports;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Reports\Report;

/**
 * Class PhpCodeSnifferReport
 *
 * @package Bruha\CodingStandard\CustomReports
 */
final class PhpCodeSnifferReport implements Report
{

    /**
     * @var string
     */
    private string $root;

    /**
     * PhpCodeSnifferReport constructor
     */
    public function __construct()
    {
        $this->root = sprintf('%s/', getcwd());
    }

    /**
     * @param mixed $report
     * @param File  $phpcsFile
     * @param mixed $showSources
     * @param mixed $width
     *
     * @return bool
     */
    public function generateFileReport(
        mixed $report,
        File $phpcsFile,
        mixed $showSources = FALSE,
        mixed $width = 80,
    ): bool {
        $phpcsFile;
        $showSources;
        $width;

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

    /**
     * @param mixed $cachedData
     * @param mixed $totalFiles
     * @param mixed $totalErrors
     * @param mixed $totalWarnings
     * @param mixed $totalFixable
     * @param mixed $showSources
     * @param mixed $width
     * @param mixed $interactive
     * @param mixed $toScreen
     */
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
        $totalFiles;
        $totalErrors;
        $totalWarnings;
        $totalFixable;
        $showSources;
        $width;
        $interactive;
        $toScreen;

        if (strlen($cachedData) !== 0) {
            echo sprintf('%s%sErrors: %s%s', $cachedData, PHP_EOL, $totalErrors, PHP_EOL);
        }
    }

}
