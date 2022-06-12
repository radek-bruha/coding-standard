<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Strings;

use Bruha\CodingStandard\CustomRules\Sniffs\Strings\ConcatenationSniff;
use Tests\AbstractTestCase;

/**
 * Class ConcatenationSniffTest
 *
 * @package Tests\Integration\CustomRules\Sniffs\Strings
 *
 * @covers \Bruha\CodingStandard\CustomRules\Sniffs\Strings\ConcatenationSniff
 * @covers \Bruha\CodingStandard\CustomRules\Sniffs\Commenting\AbstractSniff
 */
final class ConcatenationSniffTest extends AbstractTestCase
{

    /**
     * @var string
     */
    private string $sniff = ConcatenationSniff::class;

    /**
     * @covers \Bruha\CodingStandard\CustomRules\Sniffs\Strings\ConcatenationSniff::process
     */
    public function testSuccess(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/ConcatenationSniffSuccessTest.php', $this->sniff);

        self::assertSuccess($result);
    }

    /**
     * @covers \Bruha\CodingStandard\CustomRules\Sniffs\Strings\ConcatenationSniff::process
     */
    public function testMissing(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/ConcatenationSniffMissingTest.php', $this->sniff);

        self::assertNotSuccess(
            $result,
            18,
            32,
            0,
            $this->sniff,
            'CustomRules.Strings.Concatenation.Concatenation',
            'Usage of string concatenation operator is not allowed.',
        );

        self::assertNotSuccess(
            $result,
            18,
            38,
            0,
            $this->sniff,
            'CustomRules.Strings.Concatenation.Concatenation',
            'Usage of string concatenation operator is not allowed.',
        );
    }

}
