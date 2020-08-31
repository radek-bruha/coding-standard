<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Commenting;

use Bruha\CodingStandard\CustomRules\Sniffs\Commenting\ConstructorSniff;
use Tests\AbstractTestCase;

/**
 * Class ConstructorSniffTest
 *
 * @package Tests\Integration\CustomRules\Sniffs\Commenting
 *
 * @covers \Bruha\CodingStandard\CustomRules\Sniffs\Commenting\ConstructorSniff
 * @covers \Bruha\CodingStandard\CustomRules\Sniffs\Commenting\AbstractSniff
 */
final class ConstructorSniffTest extends AbstractTestCase
{

    /**
     * @var string
     */
    private string $sniff = ConstructorSniff::class;

    /**
     * @covers \Bruha\CodingStandard\CustomRules\Sniffs\Commenting\ConstructorSniff::process
     */
    public function testSuccess(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/ConstructorSniffSuccess.php', $this->sniff);

        self::assertSuccess($result);
    }

    /**
     * @covers \Bruha\CodingStandard\CustomRules\Sniffs\Commenting\ConstructorSniff::process
     */
    public function testMissing(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/ConstructorSniffMissing.php', $this->sniff);

        self::assertNotSuccess(
            $result,
            13,
            21,
            0,
            $this->sniff,
            'CustomRules.Commenting.Constructor.Comment',
            "Usage of constructor comment without 'ConstructorSniffMissing constructor' is not allowed."
        );

        self::assertNotSuccess(
            $result,
            18,
            29,
            0,
            $this->sniff,
            'CustomRules.Commenting.Constructor.Comment',
            "Usage of constructor comment without 'Anonymous constructor' is not allowed."
        );

        self::assertNotSuccess(
            $result,
            23,
            37,
            0,
            $this->sniff,
            'CustomRules.Commenting.Constructor.Comment',
            "Usage of constructor comment without 'Anonymous constructor' is not allowed."
        );
    }

}