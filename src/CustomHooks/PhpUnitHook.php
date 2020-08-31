<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomHooks;

use DG\BypassFinals;
use PHPUnit\Runner\AfterLastTestHook;
use PHPUnit\Runner\AfterTestHook;
use PHPUnit\Runner\BeforeTestHook;

/**
 * Class PhpUnitHook
 *
 * @package Bruha\CodingStandard\CustomHooks
 */
final class PhpUnitHook implements BeforeTestHook, AfterTestHook, AfterLastTestHook
{

    /**
     * @var mixed[]
     */
    private array $tests = [];

    /**
     * @var float
     */
    private float $time = 0.0;

    /**
     * @var int
     */
    private int $count = 0;

    /**
     * @param string $test
     */
    public function executeBeforeTest(string $test): void
    {
        $test;

        BypassFinals::enable();
    }

    /**
     * @param string $test
     * @param float  $time
     */
    public function executeAfterTest(string $test, float $time): void
    {
        $this->tests[(string) $time] = $test;
        $this->time                 += $time;
        $this->count++;
    }

    /**
     *
     */
    public function executeAfterLastTest(): void
    {
        krsort($this->tests, SORT_NUMERIC);

        echo sprintf(
            '%s%s%07.3fs (100.000%%): Time analysis of %s tests:%s',
            PHP_EOL,
            PHP_EOL,
            $this->time,
            $this->count,
            PHP_EOL
        );

        foreach ($this->tests as $time => $name) {
            echo sprintf('%07.3fs (%07.3f%%): %s%s', $time, $time / $this->time * 100, $name, PHP_EOL);
        }
    }

}