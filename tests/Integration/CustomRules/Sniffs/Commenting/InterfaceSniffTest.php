<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Commenting;

use Bruha\CodingStandard\CustomRules\Sniffs\Commenting\InterfaceSniff;
use Tests\AbstractTestCase;

/**
 * Class InterfaceSniffTest
 *
 * @package Tests\Integration\CustomRules\Sniffs\Commenting
 */
final class InterfaceSniffTest extends AbstractTestCase
{

    /**
     * @var string
     */
    private $sniff = InterfaceSniff::class;

    /**
     * @covers InterfaceSniff::register
     * @covers InterfaceSniff::process
     * @covers InterfaceSniff::processCommenting
     * @covers InterfaceSniff::replacePlaceholders
     */
    public function testSuccess(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/InterfaceSniffSuccess.php', $this->sniff);

        self::assertSuccess($result);
    }

    /**
     * @covers InterfaceSniff::register
     * @covers InterfaceSniff::process
     * @covers InterfaceSniff::processCommenting
     * @covers InterfaceSniff::replacePlaceholders
     */
    public function testMissing(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/InterfaceSniffMissing.php', $this->sniff);

        self::assertNotSuccess(
            $result,
            5,
            11,
            0,
            $this->sniff,
            'CustomRules.Commenting.Interface.Comment',
            "Usage of interface comment without 'Interface InterfaceSniffMissing' is not allowed."
        );

        self::assertNotSuccess(
            $result,
            5,
            11,
            1,
            $this->sniff,
            'CustomRules.Commenting.Interface.Comment',
            "Usage of interface comment without '@package Tests\Integration\CustomRules\Sniffs\Commenting\Data' is not allowed."
        );
    }

}