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
     *
     */
    public function testSuccess(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/TestSniffSuccessTest.php', $this->sniff);

        self::assertSuccess($result);
    }

    /**
     *
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
            'Test class must be final.'
        );
    }

}