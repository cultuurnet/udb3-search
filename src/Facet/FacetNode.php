<?php

namespace CultuurNet\UDB3\Search\Facet;

class FacetNode extends AbstractFacetTree
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $count;

    /**
     * @param string $key
     * @param string $name
     * @param int $count
     * @param array $children
     */
    public function __construct(
        $key,
        $name,
        $count,
        array $children = []
    ) {
        parent::__construct($key, $children);
        $this->setName($name);
        $this->setcount($count);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param string $name
     */
    private function setName($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('Facet node name should be a string.');
        }
        $this->name = $name;
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
