<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Strings\Data;

/**
 * Class ConcatenationSniffMissingTest
 *
 * @package Tests\Integration\CustomRules\Sniffs\Strings\Data
 */
final class ConcatenationSniffMissingTest
{

    /**
     * ConcatenationSniffMissingTest constructor
     */
    public function __construct()
    {
        $concatenation = 'One' . '.' . 'Two';
        $concatenation;
    }

}