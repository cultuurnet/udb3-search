<?php

namespace CultuurNet\UDB3\Search;

use Broadway\Domain\DomainMessage;
use Broadway\EventHandling\EventListenerInterface;
use CultuurNet\UDB3\Event\ReadModel\DocumentRepositoryInterface;
use CultuurNet\UDB3\Organizer\Events\OrganizerDeleted;
use CultuurNet\UDB3\Organizer\OrganizerProjectedToJSONLD;

class OrganizerSearchProjector implements EventListenerInterface
{
    /**
     * @var DocumentRepositoryInterface
     */
    private $organizerJsonLdRepository;

    /**
     * @var DocumentRepositoryInterface
     */
    private $organizerSearchRepository;

    /**
     * @param DocumentRepositoryInterface $organizerJsonLdRepository
     * @param DocumentRepositoryInterface $organizerSearchRepository
     */
    public function __construct(
        DocumentRepositoryInterface $organizerJsonLdRepository,
        DocumentRepositoryInterface $organizerSearchRepository
    ) {
        $this->organizerJsonLdRepository = $organizerJsonLdRepository;
        $this->organizerSearchRepository = $organizerSearchRepository;
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
        $organizerDocument = $this->organizerJsonLdRepository->get(
            $organizerProjectedToJSONLD->getId()
        );

        $this->organizerSearchRepository->save($organizerDocument);
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
