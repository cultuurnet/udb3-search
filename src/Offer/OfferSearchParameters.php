<?php

namespace CultuurNet\UDB3\Search\Offer;

use CultuurNet\UDB3\Label\ValueObjects\LabelName;
use CultuurNet\UDB3\Search\AbstractSearchParameters;
use CultuurNet\UDB3\Search\Region\RegionId;
use ValueObjects\StringLiteral\StringLiteral;

class OfferSearchParameters extends AbstractSearchParameters
{
    /**
     * @var RegionId
     */
    private $regionId;

    /**
     * @var StringLiteral
     */
    private $regionIndexName;

    /**
     * @var StringLiteral
     */
    private $regionDocumentType;

    /**
     * @var LabelName[]
     */
    private $labels = [];

    /**
     * @param RegionId $regionId
     * @param StringLiteral $regionIndexName
     * @param StringLiteral $regionDocumentType
     * @return OfferSearchParameters
     */
    public function withRegion(
        RegionId $regionId,
        StringLiteral $regionIndexName,
        StringLiteral $regionDocumentType
    ) {
        $c = clone $this;
        $c->regionId = $regionId;
        $c->regionIndexName = $regionIndexName;
        $c->regionDocumentType = $regionDocumentType;
        return $c;
    }

    /**
     * @param LabelName $labelName
     * @return OfferSearchParameters
     */
    public function withLabel(
        LabelName $labelName
    ) {
        $c = clone $this;
        $c->labels[] = $labelName;
        return $c;
    }

    /**
     * @param LabelName[] ...$labelNames
     * @return OfferSearchParameters
     */
    public function withLabels(
        LabelName ...$labelNames
    ) {
        $c = clone $this;
        $c->labels = array_merge($c->labels, $labelNames);
        return $c;
    }

    /**
     * @return RegionId
     */
    public function getRegionId()
    {
        return $this->regionId;
    }

    /**
     * @return StringLiteral
     */
    public function getRegionIndexName()
    {
        return $this->regionIndexName;
    }

    /**
     * @return StringLiteral
     */
    public function getRegionDocumentType()
    {
        return $this->regionDocumentType;
    }

    /**
     * @return bool
     */
    public function hasLabels()
    {
        return !empty($this->labels);
    }

    /**
     * @return LabelName[]
     */
    public function getLabels()
    {
        return $this->labels;
    }
}
