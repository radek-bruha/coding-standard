<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomSubscribers;

use PHPUnit\Event\Application\Finished;
use PHPUnit\Event\Application\FinishedSubscriber;

final readonly class PhpUnitApplicationFinishedSubscriber implements FinishedSubscriber
{

    public function __construct(private PhpUnitProcessor $phpUnitProcessor)
    {
    }

    public function notify(Finished $event): void
    {
        $tests    = $this->phpUnitProcessor->getSortedTests();
        $duration = array_sum($tests);

        echo sprintf(
            '%s%07.3fs (100.000%%): Time analysis of %s tests:%s',
            PHP_EOL,
            $duration,
            count($tests),
            PHP_EOL,
        );

        foreach ($tests as $name => $time) {
            echo sprintf('%07.3fs (%07.3f%%): %s%s', $time, $time / $duration * 100, $name, PHP_EOL);
        }
    }

}
