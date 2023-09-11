<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules;

use Bruha\CodingStandard\CustomRules\Analyzer;
use Tests\AbstractTestCase;

/**
 * @covers \Bruha\CodingStandard\CustomRules\Analyzer
 */
final class AnalyzerTest extends AbstractTestCase
{

    /**
     * @covers \Bruha\CodingStandard\CustomRules\Analyzer::phpCodeSniffer
     */
    public function testPhpCodeSniffer(): void
    {
        ob_start();
        Analyzer::phpCodeSniffer((string) file_get_contents(__DIR__ . '/analyzer.log'));
        $output = explode(PHP_EOL, (string) ob_get_contents());
        ob_end_clean();

        self::assertMatchesRegularExpression(
            '/\d+\.\d+s \(100\.000%\): Analyzed \d+ \d+ rows of logs in \d+\.\d+s with \d+\.\d+MB RAM usage/',
            $output[0],
        );
        self::assertMatchesRegularExpression('/\d+\.\d+s \(\d+\.\d+%\): .+Sniff/', $output[1]);
    }

    /**
     * @covers \Bruha\CodingStandard\CustomRules\Analyzer::phpUnit
     */
    public function testPhpUnit(): void
    {
        ob_start();
        Analyzer::phpUnit((string) file_get_contents(__DIR__ . '/analyzer.xml'));
        $output = explode(PHP_EOL, (string) ob_get_contents());
        ob_end_clean();

        self::assertMatchesRegularExpression(
            '/\d+\.\d+s \(100\.000%\): Analyzed \d+ rows of logs in \d+\.\d+s with \d+\.\d+MB RAM usage/',
            $output[0],
        );
        self::assertMatchesRegularExpression('/\d+\.\d+s \(\d+\.\d+%\): .+::.+/', $output[1]);
    }

    /**
     * @covers \Bruha\CodingStandard\CustomRules\Analyzer::phpUnitCoverage
     */
    public function testPhpUnitCoverage(): void
    {
        ob_start();
        Analyzer::phpUnitCoverage(50, __DIR__ . '/coverage.xml');
        $output = explode(PHP_EOL, (string) ob_get_contents());
        ob_end_clean();

        self::assertEquals('', $output[0]);

        ob_start();
        Analyzer::phpUnitCoverage(100, __DIR__ . '/coverage.xml');
        $output = explode(PHP_EOL, (string) ob_get_contents());
        ob_end_clean();

        self::assertEquals("\033[1;31mMinimum required code coverage is 100%, but actual is 50%!\033[0m", $output[1]);
    }

}
