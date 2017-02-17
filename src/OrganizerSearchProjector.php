<?php

namespace CultuurNet\UDB3\Search;

use CultuurNet\UDB3\Event\ReadModel\DocumentRepositoryInterface;
use CultuurNet\UDB3\Organizer\Events\OrganizerDeleted;
use CultuurNet\UDB3\Organizer\OrganizerProjectedToJSONLD;
use CultuurNet\UDB3\Search\JsonDocument\JsonDocumentTransformerInterface;
use CultuurNet\UDB3\Search\JsonDocument\PassThroughJsonDocumentTransformer;
use GuzzleHttp\ClientInterface;

class OrganizerSearchProjector extends AbstractSearchProjector
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
            $jsonDocumentTransformer = new PassThroughJsonDocumentTransformer();
        }

        parent::__construct($searchRepository, $httpClient, $jsonDocumentTransformer);
    }

    /**
     * @return array
     *
     * @uses handleOrganizerProjectedToJSONLD
     * @uses handleOrganizerDeleted
     */
    protected function getEventHandlers()
    {
        return [
            OrganizerProjectedToJSONLD::class => 'handleOrganizerProjectedToJSONLD',
            OrganizerDeleted::class => 'handleOrganizerDeleted',
        ];
    }

    /**
     * @param OrganizerProjectedToJSONLD $organizerProjectedToJSONLD
     */
    protected function handleOrganizerProjectedToJSONLD(OrganizerProjectedToJSONLD $organizerProjectedToJSONLD)
    {
        $this->index(
            $organizerProjectedToJSONLD->getId(),
            $organizerProjectedToJSONLD->getIri()
        );
    }

    /**
     * @param OrganizerDeleted $organizerDeleted
     */
    protected function handleOrganizerDeleted(OrganizerDeleted $organizerDeleted)
    {
        $this->remove(
            $organizerDeleted->getOrganizerId()
        );
    }
}
