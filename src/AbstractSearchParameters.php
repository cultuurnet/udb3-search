<?php

namespace CultuurNet\UDB3\Search;

use ValueObjects\Number\Natural;

abstract class AbstractSearchParameters
{
    /**
     * @var Natural
     */
    private $start;

    /**
     * @var Natural
     */
    private $limit;

    public function __construct()
    {
        $this->start = new Natural(0);
        $this->limit = new Natural(30);
    }

    /**
     * @param Natural $start
     * @return self
     */
    public function withStart(Natural $start)
    {
        $c = clone $this;
        $c->start = $start;
        return $c;
    }

    /**
     * @return Natural
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param Natural $limit
     * @return self
     */
    public function withLimit(Natural $limit)
    {
        $c = clone $this;
        $c->limit = $limit;
        return $c;
    }

    /**
     * @return Natural
     */
    public function getLimit()
    {
        return $this->limit;
    }
}
