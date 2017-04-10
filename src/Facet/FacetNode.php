<?php

namespace CultuurNet\UDB3\Search\Facet;

class FacetNode extends AbstractFacetTree
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var int
     */
    private $count;

    /**
     * @param string $key
     * @param string $label
     * @param int $count
     * @param array $children
     */
    public function __construct(
        $key,
        $label,
        $count,
        array $children = []
    ) {
        parent::__construct($key, $children);
        $this->setLabel($label);
        $this->setcount($count);
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param string $label
     */
    private function setLabel($label)
    {
        if (!is_string($label)) {
            throw new \InvalidArgumentException('Facet node label should be a string.');
        }
        $this->label = $label;
    }

    /**
     * @param int $count
     */
    private function setCount($count)
    {
        if (!is_int($count)) {
            throw new \InvalidArgumentException('Facet node count should be a string.');
        }
        $this->count = $count;
    }
}
