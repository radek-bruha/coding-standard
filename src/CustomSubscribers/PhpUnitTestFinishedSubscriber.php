<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomSubscribers;

use PHPUnit\Event\Test\Finished;
use PHPUnit\Event\Test\FinishedSubscriber;

final readonly class PhpUnitTestFinishedSubscriber implements FinishedSubscriber
{

    public function __construct(private PhpUnitProcessor $phpUnitProcessor)
    {
    }

    public function notify(Finished $event): void
    {
        $this->phpUnitProcessor->addTwo($event->test()->id(), $event->telemetryInfo()->time());
    }

}
