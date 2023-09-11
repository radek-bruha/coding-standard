<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomSubscribers;

use PHPUnit\Runner\Extension\Extension;
use PHPUnit\Runner\Extension\Facade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnit\TextUI\Configuration\Configuration;

final class PhpUnitExtension implements Extension
{

    public function bootstrap(Configuration $configuration, Facade $facade, ParameterCollection $parameters): void
    {
        $processor = new PhpUnitProcessor();

        $facade->registerSubscribers(
            new PhpUnitTestPreparedSubscriber($processor),
            new PhpUnitTestFinishedSubscriber($processor),
            new PhpUnitApplicationFinishedSubscriber($processor),
        );
    }

}
