<?php

namespace CultuurNet\UDB3\Search;

use CultuurNet\UDB3\Language;
use ValueObjects\Number\Natural;
use ValueObjects\StringLiteral\StringLiteral;

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
     * @var StringLiteral
     */
    private $text;

    /**
     * @var Language[]
     */
    private $textLanguages;

    public function __construct()
    {
        $this->start = new Natural(0);
        $this->limit = new Natural(30);

        $this->textLanguages = $this->getDefaultTextLanguages();

        $this->queryString = null;
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
     * @param StringLiteral $text
     * @return static
     */
    public function withText(StringLiteral $text)
    {
        $c = clone $this;
        $c->text = $text;
        return $c;
    }

    /**
     * @return bool
     */
    public function hasText()
    {
        return (bool) $this->text;
    }

    /**
     * @return StringLiteral
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param Language[] $textLanguages
     * @return static
     */
    public function withTextLanguages(Language ...$textLanguages)
    {
        $c = clone $this;
        $c->textLanguages = empty($textLanguages) ? $this->getDefaultTextLanguages() : $textLanguages;
        return $c;
    }

    /**
     * @return Language[]
     */
    public function getTextLanguages()
    {
        return $this->textLanguages;
    }

    /**
     * @return array
     */
    private function getDefaultTextLanguages()
    {
        return [
            new Language('nl'),
            new Language('fr'),
            new Language('en'),
            new Language('de'),
        ];
    }
}
