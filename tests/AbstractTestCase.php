<?php declare(strict_types=1);

namespace Tests;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Files\LocalFile;
use PHP_CodeSniffer\Runner;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractTestCase
 *
 * @package Tests
 */
abstract class AbstractTestCase extends TestCase
{

    protected const COMMAND = 'patch %s/../vendor/%s %s/../src/CustomPatches/%s%s';

    /**
     * @var Runner
     */
    private $runner;

    /**
     * AbstractTestCase constructor
     *
     * @param string|NULL $name
     * @param array       $data
     * @param string      $dataName
     */
    public function __construct(?string $name = NULL, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        include_once __DIR__ . '/../vendor/autoload.php';
        include_once __DIR__ . '/../vendor/squizlabs/php_codesniffer/autoload.php';

        $this->runner         = new Runner();
        $this->runner->config = new Config([''], FALSE);
        $this->runner->init();
    }

    /**
     * @param string $file
     * @param string $sniff
     *
     * @return LocalFile
     */
    protected function processFile(string $file, string $sniff): LocalFile
    {
        $this->runner->ruleset->sniffs = [$sniff => new $sniff()];
        $this->runner->ruleset->populateTokenListeners();

        $file = new LocalFile($file, $this->runner->ruleset, $this->runner->config);
        $file->process();

        return $file;
    }

    /**
     * @param string $file
     * @param string $patch
     * @param bool   $reverse
     */
    protected function processPatch(string $file, string $patch, bool $reverse = FALSE): void
    {
        $lines = [];

        exec(sprintf(self::COMMAND, __DIR__, $file, __DIR__, $patch, $reverse ? ' -R' : ''), $lines);

        foreach ($lines as $line) {
            if (strpos($line, 'Skipping patch') !== FALSE) {
                $this->processPatch($file, $patch, TRUE);
            }

            if (strpos($line, 'FAILED') !== FALSE) {
                self::fail(sprintf('%s: %s', $patch, $line));
            }
        }

        self::assertTrue(TRUE);
    }

    /**
     * @param LocalFile $file
     */
    protected function assertSuccess(LocalFile $file): void
    {
        self::assertEquals(0, $file->getErrorCount());
        self::assertEquals(0, $file->getWarningCount());
    }

    /**
     * @param LocalFile $file
     * @param int       $row
     * @param int       $column
     * @param int       $rank
     * @param string    $class
     * @param string    $name
     * @param string    $message
     */
    protected function assertNotSuccess(
        LocalFile $file,
        int $row,
        int $column,
        int $rank,
        string $class,
        string $name,
        string $message
    ): void {
        $error = $file->getErrors()[$row][$column][$rank];

        self::assertEquals($class, $error['listener']);
        self::assertEquals($name, $error['source']);
        self::assertEquals($message, $error['message']);
    }

}