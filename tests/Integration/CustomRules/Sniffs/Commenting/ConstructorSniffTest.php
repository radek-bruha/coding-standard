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
     *
     */
    public function testSuccess(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/ConstructorSniffSuccess.php', $this->sniff);

        $this->assertSuccess($result);
    }

    /**
     *
     */
    public function testMissing(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/ConstructorSniffMissing.php', $this->sniff);

        $this->assertNotSuccess(
            $result,
            13,
            12,
            0,
            $this->sniff,
            'CustomRules.Commenting.Constructor.Comment',
            "Constructor comment must be 'ConstructorSniffMissing constructor'."
        );
    }

    /**
     *
     */
    public function testMissingTrait(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/ConstructorSniffMissingTrait.php', $this->sniff);

        $this->assertNotSuccess(
            $result,
            13,
            12,
            0,
            $this->sniff,
            'CustomRules.Commenting.Constructor.Comment',
            "Constructor comment must be 'Unknown constructor'."
        );
    }

}