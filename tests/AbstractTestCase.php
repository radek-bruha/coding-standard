<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Files\LocalFile;
use PHP_CodeSniffer\Runner;

/**
 * Class AbstractTestCase
 *
 * @package Tests
 */
abstract class AbstractTestCase extends TestCase
{

    /**
     * @var Runner
     */
    private $runner;

    /**
     * AbstractTestCase constructor
     *
     * @param null|string $name
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
     * @param LocalFile $file
     */
    protected function assertSuccess(LocalFile $file): void
    {
        $this->assertEquals(0, $file->getErrorCount());
        $this->assertEquals(0, $file->getWarningCount());
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

        $this->assertEquals($class, $error['listener']);
        $this->assertEquals($name, $error['source']);
        $this->assertEquals($message, $error['message']);
    }

}