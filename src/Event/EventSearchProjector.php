<?php

namespace CultuurNet\UDB3\Search\Event;

use CultuurNet\UDB3\Event\Events\EventDeleted;
use CultuurNet\UDB3\Event\Events\EventProjectedToJSONLD;
use CultuurNet\UDB3\Search\AbstractSearchProjector;

class EventSearchProjector extends AbstractSearchProjector
{
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
        $this->getIndexService()->index(
            $eventProjectedToJSONLD->getItemId(),
            $eventProjectedToJSONLD->getIri()
        );
    }

    /**
     * @param EventDeleted $eventDeleted
     */
    protected function handleEventDeleted(EventDeleted $eventDeleted)
    {
        $this->getIndexService()->remove(
            $eventDeleted->getItemId()
        );
    }
}
