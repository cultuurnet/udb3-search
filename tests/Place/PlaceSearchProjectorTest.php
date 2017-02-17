<?php

namespace CultuurNet\UDB3\Search\Place;

use Broadway\Domain\DateTime;
use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;
use CultuurNet\UDB3\Event\Events\EventDeleted;
use CultuurNet\UDB3\Event\Events\EventProjectedToJSONLD;
use CultuurNet\UDB3\Event\ReadModel\DocumentRepositoryInterface;
use CultuurNet\UDB3\Place\Events\PlaceDeleted;
use CultuurNet\UDB3\Place\Events\PlaceProjectedToJSONLD;
use CultuurNet\UDB3\ReadModel\JsonDocument;
use CultuurNet\UDB3\Search\AssertJsonDocumentTrait;
use CultuurNet\UDB3\Search\JsonDocument\TransformingJsonDocumentIndexService;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Log\LoggerInterface;

class PlaceSearchProjectorTest extends \PHPUnit_Framework_TestCase
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
     * @var \CultuurNet\UDB3\Search\JsonDocument\TransformingJsonDocumentIndexService
     */
    private $indexService;

    /**
     * @var PlaceSearchProjector
     */
    private $projector;

    public function setUp()
    {
        $this->httpClient = $this->createMock(ClientInterface::class);
        $this->searchRepository = $this->createMock(DocumentRepositoryInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->indexService = new TransformingJsonDocumentIndexService(
            $this->httpClient,
            new PlaceJsonDocumentTransformer(),
            $this->searchRepository
        );

        $this->indexService->setLogger($this->logger);

        $this->projector = new PlaceSearchProjector($this->indexService);
    }

    /**
     * @test
     */
    public function it_indexes_new_and_updated_places()
    {
        $placeId = '179c89c5-dba4-417b-ae96-62e7a12c2405';
        $placeUrl = 'place/' . $placeId;
        $placeJson = file_get_contents(__DIR__ . '/data/original-with-geocoordinates.json');
        $transformedPlaceJson = file_get_contents(__DIR__ . '/data/indexed-with-geocoordinates.json');

        $indexedDocument = $this->convertJsonDocumentFromPrettyPrintToCompact(
            new JsonDocument($placeId, $transformedPlaceJson)
        );

        $domainMessage = new DomainMessage(
            $placeId,
            0,
            new Metadata(),
            new PlaceProjectedToJSONLD($placeId, $placeUrl),
            DateTime::now()
        );

        $response = new Response(200, array(), $placeJson);

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('GET', $placeUrl)
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
        $placeId = '179c89c5-dba4-417b-ae96-62e7a12c2405';
        $placeUrl = 'place/' . $placeId;

        $domainMessage = new DomainMessage(
            $placeId,
            0,
            new Metadata(),
            new PlaceProjectedToJSONLD($placeId, $placeUrl),
            DateTime::now()
        );

        $response = new Response(404);

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('GET', $placeUrl)
            ->willReturn($response);

        $this->logger->expects($this->once())
            ->method('error')
            ->with(
                'Could not retrieve JSON-LD from url for indexation.',
                [
                    'id' => $placeId,
                    'url' => $placeUrl,
                    'response' => $response
                ]
            );

        $this->projector->handle($domainMessage);
    }

    /**
     * @test
     */
    public function it_removes_deleted_places_from_the_index()
    {
        $placeId = '179c89c5-dba4-417b-ae96-62e7a12c2405';

        $domainMessage = new DomainMessage(
            $placeId,
            0,
            new Metadata(),
            new PlaceDeleted($placeId),
            DateTime::now()
        );

        $this->searchRepository->expects($this->once())
            ->method('remove')
            ->with($placeId);

        $this->projector->handle($domainMessage);
    }
}
