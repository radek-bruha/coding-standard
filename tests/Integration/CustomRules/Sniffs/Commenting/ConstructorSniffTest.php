<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Commenting;

use Bruha\CodingStandard\CustomRules\Sniffs\Commenting\ConstructorSniff;
use Tests\AbstractTestCase;

/**
 * Class ConstructorSniffTest
 *
 * @package Tests\Integration\CustomRules\Sniffs\Commenting
 */
final class ConstructorSniffTest extends AbstractTestCase
{

    /**
     * @var string
     */
    private $sniff = ConstructorSniff::class;

    /**
     * @covers
     */
    public function testSuccess(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/ConstructorSniffSuccess.php', $this->sniff);

        self::assertSuccess($result);
    }

    /**
     * @covers
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