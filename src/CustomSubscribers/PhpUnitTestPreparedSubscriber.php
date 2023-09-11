<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomSubscribers;

use PHPUnit\Event\Test\Prepared;
use PHPUnit\Event\Test\PreparedSubscriber;

final readonly class PhpUnitTestPreparedSubscriber implements PreparedSubscriber
{

    public function __construct(private PhpUnitProcessor $phpUnitProcessor)
    {
    }

    public function notify(Prepared $event): void
    {
        $this->phpUnitProcessor->addOne($event->test()->id(), $event->telemetryInfo()->time());
    }

}
