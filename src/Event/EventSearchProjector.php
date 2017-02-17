<?php

namespace CultuurNet\UDB3\Search\Event;

use CultuurNet\UDB3\Event\Events\EventDeleted;
use CultuurNet\UDB3\Event\Events\EventProjectedToJSONLD;
use CultuurNet\UDB3\Event\ReadModel\DocumentRepositoryInterface;
use CultuurNet\UDB3\Search\AbstractSearchProjector;
use CultuurNet\UDB3\Search\JsonDocument\JsonDocumentTransformerInterface;
use GuzzleHttp\ClientInterface;

class EventSearchProjector extends AbstractSearchProjector
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
            $jsonDocumentTransformer = new EventJsonDocumentTransformer();
        }

        parent::__construct($searchRepository, $httpClient, $jsonDocumentTransformer);
    }

    /**
     * @return array
     *
     * @uses handleEventProjectedToJSONLD
     * @uses handleEventDeleted
     */
    protected function getEventHandlers()
    {
        return [
            EventProjectedToJSONLD::class => 'handleEventProjectedToJSONLD',
            EventDeleted::class => 'handleEventDeleted',
        ];
    }

    /**
     * @param EventProjectedToJSONLD $eventProjectedToJSONLD
     */
    protected function handleEventProjectedToJSONLD(EventProjectedToJSONLD $eventProjectedToJSONLD)
    {
        $this->index(
            $eventProjectedToJSONLD->getItemId(),
            $eventProjectedToJSONLD->getIri()
        );
    }

    /**
     * @param EventDeleted $eventDeleted
     */
    protected function handleEventDeleted(EventDeleted $eventDeleted)
    {
        $this->remove(
            $eventDeleted->getItemId()
        );
    }
}
