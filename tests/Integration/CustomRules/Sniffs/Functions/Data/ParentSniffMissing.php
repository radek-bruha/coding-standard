<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Functions\Data;

/**
 * Class ParentSniffMissing
 *
 * @package Tests\Integration\CustomRules\Sniffs\Functions\Data
 */
final class ParentSniffMissing extends AbstractParentSniffSuccess
{

    /**
     * @var string
     */
    private $stringTwo;

    /**
     * ParentSniffMissing constructor
     *
     * @param string $stringOne
     * @param string $stringTwo
     */
    public function __construct(string $stringOne, string $stringTwo)
    {
        parent::__construct($stringOne);
        $this->stringTwo = $stringTwo;
    }

}