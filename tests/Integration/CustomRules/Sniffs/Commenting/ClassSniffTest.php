<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Commenting;

use Bruha\CodingStandard\CustomRules\Sniffs\Commenting\ClassSniff;
use Tests\AbstractTestCase;

/**
 * Class ClassSniffTest
 *
 * @package Tests\Integration\CustomRules\Sniffs\Commenting
 */
final class ClassSniffTest extends AbstractTestCase
{

    /**
     * @var string
     */
    private $sniff = ClassSniff::class;

    /**
     * @covers ClassSniff::register
     * @covers ClassSniff::process
     * @covers ClassSniff::processCommenting
     * @covers ClassSniff::replacePlaceholders
     */
    public function testSuccess(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/ClassSniffSuccess.php', $this->sniff);

        self::assertSuccess($result);
    }

    /**
     * @covers ClassSniff::register
     * @covers ClassSniff::process
     * @covers ClassSniff::processCommenting
     * @covers ClassSniff::replacePlaceholders
     */
    public function testMissing(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/ClassSniffMissing.php', $this->sniff);

        self::assertNotSuccess(
            $result,
            5,
            8,
            0,
            $this->sniff,
            'CustomRules.Commenting.Class.Comment',
            "Usage of class comment without 'Class ClassSniffMissing' is not allowed."
        );

        self::assertNotSuccess(
            $result,
            5,
            8,
            1,
            $this->sniff,
            'CustomRules.Commenting.Class.Comment',
            "Usage of class comment without '@package Tests\Integration\CustomRules\Sniffs\Commenting\Data' is not allowed."
        );
    }

}