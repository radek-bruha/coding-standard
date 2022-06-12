<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Strings\Data;

/**
 * Class ConcatenationSniffSuccessTest
 *
 * @package Tests\Integration\CustomRules\Sniffs\Strings\Data
 */
final class ConcatenationSniffSuccessTest
{

    /**
     * ConcatenationSniffSuccessTest constructor
     */
    public function __construct()
    {
        $concatenation = sprintf('%s.%s', 'One', 'Two');
        $concatenation = __DIR__ . $concatenation;
        $concatenation = $concatenation . __DIR__;
        $concatenation = __DIR__ . $concatenation . __DIR__;
        $concatenation;
    }

}
