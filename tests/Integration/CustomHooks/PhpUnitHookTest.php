<?php declare(strict_types=1);

namespace Tests\Integration\CustomHooks;

use Bruha\CodingStandard\CustomHooks\PhpUnitHook;
use Tests\AbstractTestCase;
use Tests\PrivateTrait;

/**
 * Class PhpUnitHookTest
 *
 * @package Tests\Integration\CustomHooks
 *
 * @covers \Bruha\CodingStandard\CustomHooks\PhpUnitHook
 */
final class PhpUnitHookTest extends AbstractTestCase
{

    use PrivateTrait;

    /**
     * @var PhpUnitHook
     */
    private PhpUnitHook $hook;

    /**
     * @covers \Bruha\CodingStandard\CustomHooks\PhpUnitHook::executeBeforeTest
     */
    public function testExecuteBeforeTest(): void
    {
        $this->hook->executeBeforeTest('Test');

        self::assertTrue(in_array('file', stream_get_wrappers(), TRUE));
    }

    /**
     * @covers \Bruha\CodingStandard\CustomHooks\PhpUnitHook::executeAfterTest
     */
    public function testExecuteAfterTest(): void
    {
        $this->hook->executeAfterTest('Test::test', 1);

        self::assertEquals(['1' => 'Test::test'], $this->getProperty($this->hook, 'tests'));
        self::assertEquals(1, $this->getProperty($this->hook, 'time'));
        self::assertEquals(1, $this->getProperty($this->hook, 'count'));
    }

    /**
     * @covers \Bruha\CodingStandard\CustomHooks\PhpUnitHook::executeAfterLastTest
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
        self::assertMatchesRegularExpression(
            '/\d+\.\d+s \(100\.000%\): Time analysis of \d+ tests:/',
            (string) array_shift($output),
        );
        self::assertMatchesRegularExpression(
            '/\d+\.\d+s \(\d+\.\d+%\): \w+::\w+/',
            (string) array_shift($output),
        );
    }

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->hook = new PhpUnitHook();
    }

}
