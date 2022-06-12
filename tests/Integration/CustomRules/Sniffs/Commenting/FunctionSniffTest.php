<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Commenting;

use Bruha\CodingStandard\CustomRules\Sniffs\Commenting\FunctionSniff;
use Tests\AbstractTestCase;

/**
 * Class FunctionSniffTest
 *
 * @package Tests\Integration\CustomRules\Sniffs\Commenting
 *
 * @covers \Bruha\CodingStandard\CustomRules\Sniffs\Commenting\FunctionSniff
 * @covers \Bruha\CodingStandard\CustomRules\Sniffs\Commenting\AbstractSniff
 */
final class FunctionSniffTest extends AbstractTestCase
{

    /**
     * @var string
     */
    private string $sniff = FunctionSniff::class;

    /**
     * @covers \Bruha\CodingStandard\CustomRules\Sniffs\Commenting\FunctionSniff::process
     */
    public function testSuccess(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/FunctionSniffSuccess.php', $this->sniff);

        self::assertSuccess($result);
    }

    /**
     * @covers \Bruha\CodingStandard\CustomRules\Sniffs\Commenting\FunctionSniff::process
     */
    public function testMissing(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/FunctionSniffMissing.php', $this->sniff);

        self::assertNotSuccess(
            $result,
            14,
            15,
            0,
            $this->sniff,
            'CustomRules.Commenting.Function.Comment',
            'Usage of non-rightmost null type hint is not allowed.',
        );

        self::assertNotSuccess(
            $result,
            15,
            15,
            0,
            $this->sniff,
            'CustomRules.Commenting.Function.Comment',
            'Usage of non-rightmost null type hint is not allowed.',
        );

        self::assertNotSuccess(
            $result,
            16,
            15,
            0,
            $this->sniff,
            'CustomRules.Commenting.Function.Comment',
            'Usage of non-rightmost null type hint is not allowed.',
        );
    }

}
