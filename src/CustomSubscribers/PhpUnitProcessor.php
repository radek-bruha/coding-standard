<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomSubscribers;

use PHPUnit\Event\Telemetry\HRTime;

final class PhpUnitProcessor
{

    /**
     * @var HRTime[]|float[]
     */
    private array $tests = [];

    public function addOne(string $name, HRTime $time): void
    {
        $this->tests[$name] = $time;
    }

    public function addTwo(string $name, HRTime $time): void
    {
        $test = $this->tests[$name];

        if ($test instanceof HRTime) {
            $this->tests[$name] = $time->duration($test)->asFloat();
        }
    }

    /**
     * @return float[]
     */
    public function getSortedTests(): array
    {
        /** @var float[] $tests */
        $tests = $this->tests;

        arsort($tests, SORT_NUMERIC);

        return $tests;
    }

}
