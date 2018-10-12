<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Commenting;

use Bruha\CodingStandard\CustomRules\Sniffs\Commenting\TraitSniff;
use Tests\AbstractTestCase;

/**
 * Class TraitSniffTest
 *
 * @package Tests\Integration\CustomRules\Sniffs\Commenting
 */
final class TraitSniffTest extends AbstractTestCase
{

    /**
     * @var string
     */
    private $sniff = TraitSniff::class;

    /**
     *
     */
    public function testSuccess(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/TraitSniffSuccess.php', $this->sniff);

        self::assertSuccess($result);
    }

    /**
     *
     */
    public function testMissing(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/TraitSniffMissing.php', $this->sniff);

        self::assertNotSuccess(
            $result,
            5,
            7,
            0,
            $this->sniff,
            'CustomRules.Commenting.Trait.Comment',
            "Trait comment must be 'Trait TraitSniffMissing'."
        );

        self::assertNotSuccess(
            $result,
            5,
            7,
            1,
            $this->sniff,
            'CustomRules.Commenting.Trait.Comment',
            "Trait comment must be '@package Tests\Integration\CustomRules\Sniffs\Commenting\Data'."
        );
    }

}