<?php declare(strict_types=1);

namespace Tests\Integration\CustomRules\Sniffs\Functions\Data;

/**
 * Class AbstractParentSniffSuccess
 *
 * @package Tests\Integration\CustomRules\Sniffs\Functions\Data
 */
abstract class AbstractParentSniffSuccess
{

    /**
     * @var string
     */
    protected $stringOne;

    /**
     * AbstractParentSniffSuccess constructor
     *
     * @param string $stringOne
     */
    public function __construct(string $stringOne)
    {
        $this->stringOne = $stringOne;
    }

    /**
     * @param string $stringOne
     *
     * @return self
     */
    public function setStringOne(string $stringOne): self
    {
        $this->stringOne = $stringOne;

        return $this;
    }

}