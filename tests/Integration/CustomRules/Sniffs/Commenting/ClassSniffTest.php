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
     *
     */
    public function testSuccess(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/ClassSniffSuccess.php', $this->sniff);

        $this->assertSuccess($result);
    }

    /**
     *
     */
    public function testMissing(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/ClassSniffMissing.php', $this->sniff);

        $this->assertNotSuccess(
            $result,
            5,
            13,
            0,
            $this->sniff,
            'CustomRules.Commenting.Class.Comment',
            "Class comment must be 'Class ClassSniffMissing'."
        );

        $this->assertNotSuccess(
            $result,
            5,
            13,
            1,
            $this->sniff,
            'CustomRules.Commenting.Class.Comment',
            "Class comment must be '@package Tests\Integration\CustomRules\Sniffs\Commenting\Data'."
        );
    }

}