<?php declare(strict_types=1);

namespace Tests\Integration\CustomReports;

use Bruha\CodingStandard\CustomReports\PhpCodeSnifferReport;
use PHP_CodeSniffer\Files\File;
use Tests\AbstractTestCase;

/**
 * @covers  \Bruha\CodingStandard\CustomReports\PhpCodeSnifferReport
 */
final class PhpCodeSnifferReportTest extends AbstractTestCase
{

    private const REPORT = [
        'filename' => __FILE__,
        'messages' => [
            1 => [
                1 => [
                    0 => ['message' => 'Message'],
                ],
            ],
        ],
    ];

    private PhpCodeSnifferReport $report;

    /**
     * @covers \Bruha\CodingStandard\CustomReports\PhpCodeSnifferReport::generateFileReport
     */
    public function testGenerateFileReport(): void
    {
        $file = self::createMock(File::class);

        ob_start();
        self::assertTrue($this->report->generateFileReport(self::REPORT, $file));
        $output = explode(PHP_EOL, (string) ob_get_contents());
        ob_end_clean();

        self::assertEquals('tests/Integration/CustomReports/PhpCodeSnifferReportTest.php:1: Message', $output[0]);
    }

    /**
     * @covers \Bruha\CodingStandard\CustomReports\PhpCodeSnifferReport::generate
     */
    public function testGenerate(): void
    {
        ob_start();
        $this->report->generate('tests/Integration/CustomReports/PhpCodeSnifferReportTest.php:1: Message', 1, 1, 1, 1);
        $output = explode(PHP_EOL, (string) ob_get_contents());
        ob_end_clean();

        self::assertEquals('tests/Integration/CustomReports/PhpCodeSnifferReportTest.php:1: Message', $output[0]);
        self::assertEquals('Errors: 1', $output[1]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->report = new PhpCodeSnifferReport();
    }

}
