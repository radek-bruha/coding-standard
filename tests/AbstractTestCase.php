<?php declare(strict_types=1);

namespace Tests;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Files\LocalFile;
use PHP_CodeSniffer\Runner;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{

    protected const COMMAND = 'patch %s/../vendor/%s %s/../src/CustomPatches/%s%s';

    private Runner $runner;

    public function __construct(string $name)
    {
        parent::__construct($name);

        include_once __DIR__ . '/../vendor/autoload.php';
        include_once __DIR__ . '/../vendor/squizlabs/php_codesniffer/autoload.php';

        $this->runner         = new Runner();
        $this->runner->config = new Config([''], FALSE);
        $this->runner->init();
    }

    protected function processFile(string $file, string $sniff): LocalFile
    {
        $sniffInstance = new $sniff();

        if (!$sniffInstance instanceof Sniff) {
            self::fail();
        }

        $this->runner->ruleset->sniffs = [$sniff => $sniffInstance];
        $this->runner->ruleset->populateTokenListeners();

        $file = new LocalFile($file, $this->runner->ruleset, $this->runner->config);
        $file->process();

        return $file;
    }

    protected function processPatch(string $file, string $patch, bool $reverse = FALSE): void
    {
        $lines = [];

        exec(sprintf(self::COMMAND, __DIR__, $file, __DIR__, $patch, $reverse ? ' -R' : ''), $lines);

        foreach ($lines as $line) {
            if (strpos($line, 'Skipping patch') !== FALSE) {
                $this->processPatch($file, $patch, TRUE);
            }

            if (strpos($line, 'FAILED') !== FALSE || strpos($line, 'fuzz') !== FALSE) {
                self::fail(sprintf('%s: %s', $patch, $line));
            }
        }

        self::assertEquals(1, TRUE);
    }

    protected function assertSuccess(LocalFile $file): void
    {
        self::assertEquals(0, $file->getErrorCount());
        self::assertEquals(0, $file->getWarningCount());
    }

    protected function assertNotSuccess(
        LocalFile $file,
        int $row,
        int $column,
        int $rank,
        string $class,
        string $name,
        string $message,
        int $columnTwo = 0,
    ): void {
        $error = $file->getErrors()[$row][$column][$rank] ?? $file->getErrors()[$row][$columnTwo][$rank];

        self::assertEquals($class, $error['listener']);
        self::assertEquals($name, $error['source']);
        self::assertEquals($message, $error['message']);
    }

}
