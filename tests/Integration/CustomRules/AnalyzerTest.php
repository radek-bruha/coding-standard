<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules;

use Bruha\CodingStandard\CustomRules\Analyzer;
use Tests\AbstractTestCase;

/**
 * Class AnalyzerTest
 *
 * @package Tests\Integration\CustomRules
 */
final class AnalyzerTest extends AbstractTestCase
{

    /**
     *
     */
    public function testPhpCodeSniffer(): void
    {
        ob_start();
        Analyzer::phpCodeSniffer((string) file_get_contents(__DIR__ . '/analyzer.log'));
        $output = explode(PHP_EOL, (string) ob_get_contents());
        ob_end_clean();

        self::assertGreaterThan(0, count($output));
        self::assertEquals('', array_pop($output));
        self::assertRegExp(
            '/\d+\.\d+s \(100\.000%\): Analyzed \d+ \d+ rows of logs in \d+\.\d+s with \d+\.\d+MB RAM usage/',
            (string) array_shift($output)
        );
        self::assertRegExp(
            '/.+ \(\d+\.\d+%\): .+Sniff/',
            (string) array_shift($output)
        );
    }

    /**
     *
     */
    public function testPhpUnit(): void
    {
        ob_start();
        Analyzer::phpUnit((string) file_get_contents(__DIR__ . '/analyzer.xml'));
        $output = explode(PHP_EOL, (string) ob_get_contents());
        ob_end_clean();

        self::assertGreaterThan(0, count($output));
        self::assertEquals('', array_pop($output));
        self::assertRegExp(
            '/\d+\.\d+s \(100\.000%\): Analyzed \d+ rows of logs in \d+\.\d+s with \d+\.\d+MB RAM usage/',
            (string) array_shift($output)
        );
        self::assertRegExp(
            '/.+ \(\d+\.\d+%\): .+Test::test.+/',
            (string) array_shift($output)
        );
    }

}