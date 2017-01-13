<?php

namespace CultuurNet\UDB3\Search;

use Broadway\Domain\DomainMessage;
use Broadway\EventHandling\EventListenerInterface;
use CultuurNet\UDB3\Event\ReadModel\DocumentRepositoryInterface;
use CultuurNet\UDB3\Organizer\Events\OrganizerDeleted;
use CultuurNet\UDB3\Organizer\OrganizerProjectedToJSONLD;
use CultuurNet\UDB3\ReadModel\JsonDocument;
use GuzzleHttp\ClientInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

class OrganizerSearchProjector implements EventListenerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var DocumentRepositoryInterface
     */
    private $organizerSearchRepository;

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @param DocumentRepositoryInterface $organizerSearchRepository
     * @param ClientInterface $httpClient
     */
    public function __construct(
        DocumentRepositoryInterface $organizerSearchRepository,
        ClientInterface $httpClient
    ) {
        $this->organizerSearchRepository = $organizerSearchRepository;
        $this->httpClient = $httpClient;
        $this->logger = new NullLogger();
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
        $response = $this->httpClient->request('GET', $organizerProjectedToJSONLD->getIri());

        if ($response->getStatusCode() == 200) {
            $jsonLd = $response->getBody();

            $jsonDocument = new JsonDocument(
                $organizerProjectedToJSONLD->getId(),
                $jsonLd
            );

            $this->organizerSearchRepository->save($jsonDocument);
        } else {
            $this->logger->error(
                'Could not retrieve organizer JSON-LD from url for indexation.',
                [
                    'id' => $organizerProjectedToJSONLD->getId(),
                    'url' => $organizerProjectedToJSONLD->getIri(),
                    'response' => $response
                ]
            );
        }
    }

    /**
     * @param OrganizerDeleted $organizerDeleted
     */
    private function handleOrganizerDeleted(OrganizerDeleted $organizerDeleted)
    {
        $this->organizerSearchRepository->remove(
            $organizerDeleted->getOrganizerId()
        );
    }
}
