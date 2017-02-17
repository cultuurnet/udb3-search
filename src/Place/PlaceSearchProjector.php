<?php

namespace CultuurNet\UDB3\Search\Place;

use CultuurNet\UDB3\Event\ReadModel\DocumentRepositoryInterface;
use CultuurNet\UDB3\Place\Events\PlaceDeleted;
use CultuurNet\UDB3\Place\Events\PlaceProjectedToJSONLD;
use CultuurNet\UDB3\Search\AbstractSearchProjector;
use CultuurNet\UDB3\Search\JsonDocument\JsonDocumentTransformerInterface;
use GuzzleHttp\ClientInterface;

class PlaceSearchProjector extends AbstractSearchProjector
{
    /**
     * @param DocumentRepositoryInterface $searchRepository
     * @param ClientInterface $httpClient
     * @param JsonDocumentTransformerInterface|null $jsonDocumentTransformer
     */
    public function __construct(
        DocumentRepositoryInterface $searchRepository,
        ClientInterface $httpClient,
        JsonDocumentTransformerInterface $jsonDocumentTransformer = null
    ) {
        if (is_null($jsonDocumentTransformer)) {
            $jsonDocumentTransformer = new PlaceJsonDocumentTransformer();
        }

        parent::__construct($searchRepository, $httpClient, $jsonDocumentTransformer);
    }

    /**
     * @return array
     *
     * @uses handlePlaceProjectedToJSONLD
     * @uses handlePlaceDeleted
     */
    protected function getEventHandlers()
    {
        return [
            PlaceProjectedToJSONLD::class => 'handlePlaceProjectedToJSONLD',
            PlaceDeleted::class => 'handlePlaceDeleted',
        ];
    }

    /**
     * @param PlaceProjectedToJSONLD $placeProjectedToJSONLD
     */
    protected function handlePlaceProjectedToJSONLD(PlaceProjectedToJSONLD $placeProjectedToJSONLD)
    {
        $this->index(
            $placeProjectedToJSONLD->getItemId(),
            $placeProjectedToJSONLD->getIri()
        );
    }

    /**
     * @param PlaceDeleted $placeDeleted
     */
    protected function handlePlaceDeleted(PlaceDeleted $placeDeleted)
    {
        $this->remove(
            $placeDeleted->getItemId()
        );
    }
}
