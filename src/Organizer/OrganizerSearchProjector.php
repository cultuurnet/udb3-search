<?php

namespace CultuurNet\UDB3\Search\Organizer;

use CultuurNet\UDB3\Organizer\Events\OrganizerDeleted;
use CultuurNet\UDB3\Organizer\OrganizerProjectedToJSONLD;
use CultuurNet\UDB3\Search\AbstractSearchProjector;

class OrganizerSearchProjector extends AbstractSearchProjector
{
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
        $this->getIndexService()->index(
            $organizerProjectedToJSONLD->getId(),
            $organizerProjectedToJSONLD->getIri()
        );
    }

    /**
     * @param OrganizerDeleted $organizerDeleted
     */
    protected function handleOrganizerDeleted(OrganizerDeleted $organizerDeleted)
    {
        $this->getIndexService()->remove(
            $organizerDeleted->getOrganizerId()
        );
    }
}
