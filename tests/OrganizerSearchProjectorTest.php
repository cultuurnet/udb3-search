<?php

namespace CultuurNet\UDB3\Search;

use Broadway\Domain\DateTime;
use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;
use CultuurNet\UDB3\Event\ReadModel\DocumentRepositoryInterface;
use CultuurNet\UDB3\Organizer\Events\OrganizerDeleted;
use CultuurNet\UDB3\Organizer\OrganizerProjectedToJSONLD;
use CultuurNet\UDB3\ReadModel\JsonDocument;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Log\LoggerInterface;

class OrganizerSearchProjectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DocumentRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $searchRepository;

    /**
     * @var ClientInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $httpClient;

    /**
     * @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $logger;

    /**
     * @var OrganizerSearchProjector
     */
    private $projector;

    public function setUp()
    {
        $this->httpClient = $this->createMock(ClientInterface::class);
        $this->searchRepository = $this->createMock(DocumentRepositoryInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->projector = new OrganizerSearchProjector(
            $this->searchRepository,
            $this->httpClient
        );

        $this->projector->setLogger($this->logger);
    }

    /**
     * @test
     */
    public function it_indexes_new_and_updated_organizers()
    {
        $organizerId = '45df0ff9-957f-4abe-8c97-114adf8296db';
        $organizerUrl = 'organizers/' . $organizerId;
        $organizerJson = file_get_contents(__DIR__ . '/data/organizer.json');

        $organizerDocument = new JsonDocument($organizerId, $organizerJson);

        $domainMessage = new DomainMessage(
            $organizerId,
            0,
            new Metadata(),
            new OrganizerProjectedToJSONLD($organizerId, $organizerUrl),
            DateTime::now()
        );

        $response = new Response(200, array(), $organizerJson);

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('GET', $organizerUrl)
            ->willReturn($response);

        $this->searchRepository->expects($this->once())
            ->method('save')
            ->with($organizerDocument);

        $this->projector->handle($domainMessage);
    }

    /**
     * @test
     */
    public function it_logs_an_error_when_the_jsonld_can_not_be_found()
    {
        $organizerId = '45df0ff9-957f-4abe-8c97-114adf8296db';
        $organizerUrl = 'organizers/' . $organizerId;

        $domainMessage = new DomainMessage(
            $organizerId,
            0,
            new Metadata(),
            new OrganizerProjectedToJSONLD($organizerId, $organizerUrl),
            DateTime::now()
        );

        $response = new Response(404);

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('GET', $organizerUrl)
            ->willReturn($response);

        $this->logger->expects($this->once())
            ->method('error')
            ->with(
                'Could not retrieve JSON-LD from url for indexation.',
                [
                    'id' => $organizerId,
                    'url' => $organizerUrl,
                    'response' => $response
                ]
            );

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
