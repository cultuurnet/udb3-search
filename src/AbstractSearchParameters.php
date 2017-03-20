<?php

namespace CultuurNet\UDB3\Search;

use CultuurNet\UDB3\Language;
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

    /**
     * @var AbstractQueryString|null
     */
    private $queryString;

    /**
     * @var Language
     */
    private $textLanguage;

    public function __construct()
    {
        $this->start = new Natural(0);
        $this->limit = new Natural(30);
        $this->queryString = null;
        $this->textLanguage = null;
    }

    /**
     * @param Natural $start
     * @return static
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
     * @return static
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

    /**
     * @param AbstractQueryString $queryString
     * @return static
     */
    public function withQueryString(AbstractQueryString $queryString)
    {
        $c = clone $this;
        $c->queryString = $queryString;
        return $c;
    }

    /**
     * @return bool
     */
    public function hasQueryString()
    {
        return (bool) $this->queryString;
    }

    /**
     * @return AbstractQueryString|null
     */
    public function getQueryString()
    {
        return $this->queryString;
    }

    /**
     * @param Language $textLanguage
     * @return static
     */
    public function withTextLanguage(Language $textLanguage)
    {
        $c = clone $this;
        $c->textLanguage = $textLanguage;
        return $c;
    }

    /**
     * @return bool
     */
    public function hasTextLanguage()
    {
        return (bool) $this->textLanguage;
    }

    /**
     * @return Language|null
     */
    public function getTextLanguage()
    {
        return $this->textLanguage;
    }
}
