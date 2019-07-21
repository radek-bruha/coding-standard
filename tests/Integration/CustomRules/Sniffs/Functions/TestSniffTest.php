<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Functions;

use Bruha\CodingStandard\CustomRules\Sniffs\Functions\TestSniff;
use Tests\AbstractTestCase;

/**
 * Class TestSniffTest
 *
 * @package Tests\Integration\CustomRules\Sniffs\Functions
 */
final class TestSniffTest extends AbstractTestCase
{

    /**
     * @var string
     */
    private $sniff = TestSniff::class;

    /**
     * @covers
     */
    public function testSuccess(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/TestSniffSuccessTest.php', $this->sniff);

        self::assertSuccess($result);
    }

    /**
     * @covers
     */
    public function testMissing(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/TestSniffMissingTest.php', $this->sniff);

        self::assertNotSuccess(
            $result,
            10,
            1,
            0,
            $this->sniff,
            'CustomRules.Functions.Test.Final',
            'Usage of abstract or normal test class is not allowed.'
        );

        self::assertNotSuccess(
            $result,
            13,
            5,
            0,
            $this->sniff,
            'CustomRules.Functions.Test.Covers',
            'Usage of test method without @covers annotation is not allowed.'
        );

        self::assertNotSuccess(
            $result,
            21,
            5,
            0,
            $this->sniff,
            'CustomRules.Functions.Test.Covers',
            'Usage of @covers annotation with namespace is not allowed.'
        );
    }

}