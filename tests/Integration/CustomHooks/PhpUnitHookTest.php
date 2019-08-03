<?php declare(strict_types=1);

namespace Tests\Integration\CustomHooks;

use Bruha\CodingStandard\CustomHooks\PhpUnitHook;
use DG\BypassFinals;
use Tests\AbstractTestCase;
use Tests\PrivateTrait;

/**
 * Class PhpUnitHookTest
 *
 * @package Tests\Integration\CustomHooks
 */
final class PhpUnitHookTest extends AbstractTestCase
{

    use PrivateTrait;

    /**
     * @var PhpUnitHook
     */
    private $hook;

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->hook = new PhpUnitHook();
    }

    /**
     * @covers PhpUnitHook::executeBeforeTest
     */
    public function testExecuteBeforeTest(): void
    {
        $this->hook->executeBeforeTest('Test');

        self::assertTrue(in_array(BypassFinals::PROTOCOL, stream_get_wrappers(), TRUE));
    }

    /**
     * @covers PhpUnitHook::executeAfterTest
     */
    public function testExecuteAfterTest(): void
    {
        $this->hook->executeAfterTest('Test::test', 1);

        self::assertEquals(['1' => 'Test::test'], $this->getProperty($this->hook, 'tests'));
        self::assertEquals(1, $this->getProperty($this->hook, 'time'));
        self::assertEquals(1, $this->getProperty($this->hook, 'count'));
    }

    /**
     * @covers PhpUnitHook::executeAfterLastTest
     */
    public function testExecuteAfterLastTest(): void
    {
        ob_start();
        $this->hook->executeAfterTest('Test::test', 1);
        $this->hook->executeAfterLastTest();
        $output = explode(PHP_EOL, (string) ob_get_contents());
        ob_end_clean();

        self::assertGreaterThan(0, count($output));
        self::assertEquals('', array_pop($output));
        self::assertEquals('', array_shift($output));
        self::assertEquals('', array_shift($output));
        self::assertRegExp(
            '/\d+\.\d+s \(100\.000%\): Time analysis of \d+ tests:/',
            (string) array_shift($output)
        );
        self::assertRegExp(
            '/\d+\.\d+s \(\d+\.\d+%\): \w+::\w+/',
            (string) array_shift($output)
        );
    }

}