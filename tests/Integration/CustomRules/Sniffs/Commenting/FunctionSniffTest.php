<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Commenting;

use Bruha\CodingStandard\CustomRules\Sniffs\Commenting\FunctionSniff;
use Tests\AbstractTestCase;

/**
 * Class FunctionSniffTest
 *
 * @package Tests\Integration\CustomRules\Sniffs\Commenting
 */
final class FunctionSniffTest extends AbstractTestCase
{

    /**
     * @var string
     */
    private $sniff = FunctionSniff::class;

    /**
     * @covers
     */
    public function testSuccess(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/FunctionSniffSuccess.php', $this->sniff);

        self::assertSuccess($result);
    }

    /**
     * @covers
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
            'Usage of non-rightmost NULL type hint is not allowed.'
        );

        self::assertNotSuccess(
            $result,
            15,
            15,
            0,
            $this->sniff,
            'CustomRules.Commenting.Function.Comment',
            'Usage of non-rightmost NULL type hint is not allowed.'
        );

        self::assertNotSuccess(
            $result,
            16,
            15,
            0,
            $this->sniff,
            'CustomRules.Commenting.Function.Comment',
            'Usage of non-rightmost NULL type hint is not allowed.'
        );
    }

}