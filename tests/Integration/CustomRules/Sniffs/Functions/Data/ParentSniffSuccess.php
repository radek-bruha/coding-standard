<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Functions\Data;

/**
 * Class ParentSniffSuccess
 *
 * @package Tests\Integration\CustomRules\Sniffs\Functions\Data
 */
final class ParentSniffSuccess extends AbstractParentSniffSuccess
{

    /**
     * @var string
     */
    private $stringTwo;

    /**
     * ParentSniffSuccess constructor
     *
     * @param string $stringOne
     * @param string $stringTwo
     */
    public function __construct(string $stringOne, string $stringTwo)
    {
        parent::__construct($stringOne);

        $this->stringTwo = $stringTwo;
    }

    /**
     * @param string $stringOne
     *
     * @return AbstractParentSniffSuccess
     */
    public function setStringOne(string $stringOne): AbstractParentSniffSuccess
    {
        return parent::setStringOne($stringOne);
    }

}