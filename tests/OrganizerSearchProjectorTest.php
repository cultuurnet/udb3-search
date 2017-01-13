<?php

namespace CultuurNet\UDB3\Search;

use Broadway\Domain\DateTime;
use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;
use CultuurNet\UDB3\Event\ReadModel\DocumentRepositoryInterface;
use CultuurNet\UDB3\Organizer\Events\OrganizerDeleted;
use CultuurNet\UDB3\Organizer\OrganizerProjectedToJSONLD;
use CultuurNet\UDB3\ReadModel\JsonDocument;

class OrganizerSearchProjectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DocumentRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $jsonRepository;

    /**
     * @var DocumentRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $searchRepository;

    /**
     * @var OrganizerSearchProjector
     */
    private $projector;

    public function setUp()
    {
        $this->jsonRepository = $this->createMock(DocumentRepositoryInterface::class);
        $this->searchRepository = $this->createMock(DocumentRepositoryInterface::class);

        $this->projector = new OrganizerSearchProjector(
            $this->jsonRepository,
            $this->searchRepository
        );
    }

    /**
     * @test
     */
    public function it_indexes_new_and_updated_organizers()
    {
        $organizerId = '45df0ff9-957f-4abe-8c97-114adf8296db';
        $organizerJson = file_get_contents(__DIR__ . '/data/organizer.json');

        $organizerDocument = new JsonDocument($organizerId, $organizerJson);

        $domainMessage = new DomainMessage(
            $organizerId,
            0,
            new Metadata(),
            new OrganizerProjectedToJSONLD($organizerId),
            DateTime::now()
        );

        $this->jsonRepository->expects($this->once())
            ->method('get')
            ->with($organizerId)
            ->willReturn($organizerDocument);

        $this->searchRepository->expects($this->once())
            ->method('save')
            ->with($organizerDocument);

        $this->projector->handle($domainMessage);
    }

    /**
     * @test
     */
    public function it_removes_deleted_organizers_from_the_index()
    {
        $organizerId = '45df0ff9-957f-4abe-8c97-114adf8296db';

        $domainMessage = new DomainMessage(
            $organizerId,
            0,
            new Metadata(),
            new OrganizerDeleted($organizerId),
            DateTime::now()
        );

        $this->searchRepository->expects($this->once())
            ->method('remove')
            ->with($organizerId);

        $this->projector->handle($domainMessage);
    }
}
