<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Functions;

use Bruha\CodingStandard\CustomRules\Sniffs\Functions\ParentSniff;
use Tests\AbstractTestCase;

/**
 * Class ParentSniffTest
 *
 * @package Tests\Integration\CustomRules\Sniffs\Functions
 */
final class ParentSniffTest extends AbstractTestCase
{

    /**
     * @var string
     */
    private $sniff = ParentSniff::class;

    /**
     *
     */
    public function testSuccess(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/ParentSniffSuccess.php', $this->sniff);

        self::assertSuccess($result);
    }

    /**
     *
     */
    public function testMissing(): void
    {
        $result = $this->processFile(__DIR__ . '/Data/ParentSniffMissing.php', $this->sniff);

        self::assertNotSuccess(
            $result,
            26,
            9,
            0,
            $this->sniff,
            'CustomRules.Functions.Parent.NewLine',
            'Parent call must be followed by single blank line.'
        );
    }

}