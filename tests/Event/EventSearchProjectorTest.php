<?php

namespace CultuurNet\UDB3\Search\Event;

use Broadway\Domain\DateTime;
use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;
use CultuurNet\UDB3\Event\Events\EventDeleted;
use CultuurNet\UDB3\Event\Events\EventProjectedToJSONLD;
use CultuurNet\UDB3\Event\ReadModel\DocumentRepositoryInterface;
use CultuurNet\UDB3\ReadModel\JsonDocument;
use CultuurNet\UDB3\Search\AssertJsonDocumentTrait;
use CultuurNet\UDB3\Search\JsonDocument\TransformingJsonDocumentIndexService;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Log\LoggerInterface;

class EventSearchProjectorTest extends \PHPUnit_Framework_TestCase
{
    use AssertJsonDocumentTrait;

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
     * @var TransformingJsonDocumentIndexService
     */
    private $indexService;

    /**
     * @var EventSearchProjector
     */
    private $projector;

    public function setUp()
    {
        $this->httpClient = $this->createMock(ClientInterface::class);
        $this->searchRepository = $this->createMock(DocumentRepositoryInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->indexService = new TransformingJsonDocumentIndexService(
            $this->httpClient,
            new EventJsonDocumentTransformer(),
            $this->searchRepository
        );

        $this->indexService->setLogger($this->logger);

        $this->projector = new EventSearchProjector($this->indexService);
    }

    /**
     * @test
     */
    public function it_indexes_new_and_updated_events()
    {
        $eventId = '23017cb7-e515-47b4-87c4-780735acc942';
        $eventUrl = 'event/' . $eventId;
        $eventJson = file_get_contents(__DIR__ . '/data/original-with-geocoordinates.json');
        $transformedEventJson = file_get_contents(__DIR__ . '/data/indexed-with-geocoordinates.json');

        $indexedDocument = $this->convertJsonDocumentFromPrettyPrintToCompact(
            new JsonDocument($eventId, $transformedEventJson)
        );

        $domainMessage = new DomainMessage(
            $eventId,
            0,
            new Metadata(),
            new EventProjectedToJSONLD($eventId, $eventUrl),
            DateTime::now()
        );

        $response = new Response(200, array(), $eventJson);

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('GET', $eventUrl)
            ->willReturn($response);

        $this->searchRepository->expects($this->once())
            ->method('save')
            ->with($indexedDocument);

        $this->projector->handle($domainMessage);
    }

    /**
     * @test
     */
    public function it_logs_an_error_when_the_jsonld_can_not_be_found()
    {
        $eventId = '23017cb7-e515-47b4-87c4-780735acc942';
        $eventUrl = 'event/' . $eventId;

        $domainMessage = new DomainMessage(
            $eventId,
            0,
            new Metadata(),
            new EventProjectedToJSONLD($eventId, $eventUrl),
            DateTime::now()
        );

        $response = new Response(404);

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('GET', $eventUrl)
            ->willReturn($response);

        $this->logger->expects($this->once())
            ->method('error')
            ->with(
                'Could not retrieve JSON-LD from url for indexation.',
                [
                    'id' => $eventId,
                    'url' => $eventUrl,
                    'response' => $response
                ]
            );

        $this->projector->handle($domainMessage);
    }

    /**
     * @test
     */
    public function it_removes_deleted_events_from_the_index()
    {
        $eventId = '23017cb7-e515-47b4-87c4-780735acc942';

        $domainMessage = new DomainMessage(
            $eventId,
            0,
            new Metadata(),
            new EventDeleted($eventId),
            DateTime::now()
        );

        $this->searchRepository->expects($this->once())
            ->method('remove')
            ->with($eventId);

        $this->projector->handle($domainMessage);
    }
}
