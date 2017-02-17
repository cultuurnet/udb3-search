<?php

namespace CultuurNet\UDB3\Search;

use Broadway\Domain\DomainMessage;
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
     * @param DomainMessage $domainMessage
     *
     * @uses handleOrganizerProjectedToJSONLD
     * @uses handleOrganizerDeleted
     */
    public function handle(DomainMessage $domainMessage)
    {
        $handlers = [
            OrganizerProjectedToJSONLD::class => 'handleOrganizerProjectedToJSONLD',
            OrganizerDeleted::class => 'handleOrganizerDeleted',
        ];

        $payload = $domainMessage->getPayload();
        $payloadType = get_class($payload);

        if (array_key_exists($payloadType, $handlers) &&
            method_exists($this, $handlers[$payloadType])) {
            $handler = $handlers[$payloadType];
            $this->{$handler}($payload);
        }
    }

    /**
     * @param OrganizerProjectedToJSONLD $organizerProjectedToJSONLD
     */
    private function handleOrganizerProjectedToJSONLD(OrganizerProjectedToJSONLD $organizerProjectedToJSONLD)
    {
        $this->index(
            $organizerProjectedToJSONLD->getId(),
            $organizerProjectedToJSONLD->getIri()
        );
    }

    /**
     * @param OrganizerDeleted $organizerDeleted
     */
    private function handleOrganizerDeleted(OrganizerDeleted $organizerDeleted)
    {
        $this->remove(
            $organizerDeleted->getOrganizerId()
        );
    }
}
