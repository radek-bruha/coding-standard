<?php declare(strict_types=1);

namespace Tests\Integration\CustomPatches;

use Tests\AbstractTestCase;

/**
 * Class PatchesTest
 *
 * @package Tests\Integration\CustomPatches
 */
final class PatchesTest extends AbstractTestCase
{

    /**
     * @covers
     */
    public function testPhpCodeSniffer(): void
    {
        $this->processPatch('squizlabs/php_codesniffer/src/Runner.php', 'PHPCodeSnifferOne.patch');
        $this->processPatch('squizlabs/php_codesniffer/src/Reports/Full.php', 'PHPCodeSnifferTwo.patch');
    }

    /**
     * @covers
     */
    public function testPhpStan(): void
    {
        $this->processPatch('phpstan/phpstan/src/Command/ErrorsConsoleStyle.php', 'PHPStanOne.patch');
        $this->processPatch('phpstan/phpstan/src/Command/ErrorFormatter/TableErrorFormatter.php', 'PHPStanTwo.patch');
    }

    /**
     * @covers
     */
    public function testPhpUnit(): void
    {
        $this->processPatch('phpunit/phpunit/src/TextUI/TestRunner.php', 'PHPUnitOne.patch');
        $this->processPatch('phpunit/phpunit/src/TextUI/ResultPrinter.php', 'PHPUnitTwo.patch');
    }

    /**
     * @covers
     */
    public function testPhpParaTest(): void
    {
        $this->processPatch('brianium/paratest/src/Runners/PHPUnit/ResultPrinter.php', 'PHPParaTest.patch');
    }

    /**
     * @covers
     */
    public function testPhpInfection(): void
    {
        $this->processPatch(
            'infection/infection/src/Console/Application.php',
            'PHPInfectionOne.patch'
        );
        $this->processPatch(
            'infection/infection/src/Console/OutputFormatter/DotFormatter.php',
            'PHPInfectionTwo.patch'
        );
        $this->processPatch(
            'infection/infection/src/Process/Listener/CleanUpAfterMutationTestingFinishedSubscriber.php',
            'PHPInfectionThree.patch'
        );
        $this->processPatch(
            'infection/infection/src/Process/Listener/InitialTestsConsoleLoggerSubscriber.php',
            'PHPInfectionFour.patch'
        );
        $this->processPatch(
            'infection/infection/src/Process/Listener/MutantCreatingConsoleLoggerSubscriber.php',
            'PHPInfectionFive.patch'
        );
        $this->processPatch(
            'infection/infection/src/Process/Listener/MutationGeneratingConsoleLoggerSubscriber.php',
            'PHPInfectionSix.patch'
        );
        $this->processPatch(
            'infection/infection/src/Process/Listener/MutationTestingConsoleLoggerSubscriber.php',
            'PHPInfectionSeven.patch'
        );
        $this->processPatch(
            'infection/infection/src/Process/Listener/MutationTestingResultsLoggerSubscriber.php',
            'PHPInfectionEight.patch'
        );
        $this->processPatch(
            'infection/infection/src/Performance/Listener/PerformanceLoggerSubscriber.php',
            'PHPInfectionNine.patch'
        );
    }

    /**
     * @covers
     */
    public function testDoctrineAnnotation(): void
    {
        $this->processPatch(
            'stesie/phpcs-doctrine-annotation-rules/src/DoctrineAnnotationCodingStandard/Sniffs/Commenting/AbstractDoctrineAnnotationSniff.php',
            'DoctrineAnnotationOne.patch'
        );
        $this->processPatch(
            'stesie/phpcs-doctrine-annotation-rules/src/DoctrineAnnotationCodingStandard/Helper/TypeHelper.php',
            'DoctrineAnnotationTwo.patch'
        );
    }

}