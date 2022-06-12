<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Functions;

use Bruha\CodingStandard\CustomRules\Sniffs\Functions\TestSniff;
use Tests\AbstractTestCase;

/**
 * Class TestSniffTest
 *
 * @package Tests\Integration\CustomRules\Sniffs\Functions
 *
 * @covers \Bruha\CodingStandard\CustomRules\Sniffs\Functions\TestSniff
 * @covers \Bruha\CodingStandard\CustomRules\Sniffs\Commenting\AbstractSniff
 */
final class TestSniffTest extends AbstractTestCase
{

    /**
     * @var string
     */
    private string $sniff = TestSniff::class;

    /**
     * @covers \Bruha\CodingStandard\CustomRules\Sniffs\Functions\TestSniff::process
     */
    public function testSuccess(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/TestSniffSuccessTest.php', $this->sniff);

        self::assertSuccess($result);
    }

    /**
     * @covers \Bruha\CodingStandard\CustomRules\Sniffs\Functions\TestSniff::process
     */
    public function testMissing(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/TestSniffMissingTest.php', $this->sniff);

        self::assertNotSuccess(
            $result,
            13,
            5,
            0,
            $this->sniff,
            'CustomRules.Functions.Test.Covers',
            'Usage of test method without @covers annotation is not allowed.',
        );

        self::assertNotSuccess(
            $result,
            21,
            5,
            0,
            $this->sniff,
            'CustomRules.Functions.Test.Covers',
            'Usage of @covers annotation without namespace is not allowed.',
        );
    }

}
