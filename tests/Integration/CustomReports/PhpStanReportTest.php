<?php declare(strict_types=1);

namespace Tests\Integration\CustomReports;

use Bruha\CodingStandard\CustomReports\PhpStanReport;
use PHPStan\Analyser\Error;
use PHPStan\Command\AnalysisResult;
use PHPStan\Command\OutputStyle;
use PHPStan\Command\Symfony\SymfonyOutput;
use Tests\AbstractTestCase;

/**
 * @covers \Bruha\CodingStandard\CustomReports\PhpStanReport
 */
final class PhpStanReportTest extends AbstractTestCase
{

    private PhpStanReport $report;

    /**
     * @covers \Bruha\CodingStandard\CustomReports\PhpStanReport::formatErrors
     */
    public function testFormatErrors(): void
    {
        $style = self::createMock(OutputStyle::class);
        $style->method('newLine')->willReturnCallback(
            static function (): void {
                echo PHP_EOL;
            },
        );

        $output = self::createMock(SymfonyOutput::class);
        $output->method('getStyle')->willReturn($style);

        ob_start();
        self::assertEquals(
            1,
            $this->report->formatErrors(
                new AnalysisResult(
                    [new Error('Message', __FILE__, 1)],
                    ['Message'],
                    [],
                    [],
                    [],
                    FALSE,
                    NULL,
                    FALSE,
                    0,
                ),
                $output,
            ),
        );
        $output = explode(PHP_EOL, (string) ob_get_contents());
        ob_end_clean();

        self::assertEquals('tests/Integration/CustomReports/PhpStanReportTest.php:1: Message', $output[0]);
        self::assertEquals('Message', $output[1]);
        self::assertEquals('Errors: 2', $output[3]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->report = new PhpStanReport();
    }

}
