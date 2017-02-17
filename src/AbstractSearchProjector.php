<?php

namespace CultuurNet\UDB3\Search;

use Broadway\Domain\DomainMessage;
use Broadway\EventHandling\EventListenerInterface;
use CultuurNet\UDB3\Event\ReadModel\DocumentRepositoryInterface;
use CultuurNet\UDB3\ReadModel\JsonDocument;
use CultuurNet\UDB3\Search\JsonDocument\JsonDocumentTransformerInterface;
use GuzzleHttp\ClientInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

abstract class AbstractSearchProjector implements EventListenerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var DocumentRepositoryInterface
     */
    private $searchRepository;

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var JsonDocumentTransformerInterface
     */
    private $jsonDocumentTransformer;

    /**
     * @param DocumentRepositoryInterface $searchRepository
     * @param ClientInterface $httpClient
     * @param JsonDocumentTransformerInterface $jsonDocumentTransformer
     */
    public function __construct(
        DocumentRepositoryInterface $searchRepository,
        ClientInterface $httpClient,
        JsonDocumentTransformerInterface $jsonDocumentTransformer
    ) {
        $this->searchRepository = $searchRepository;
        $this->httpClient = $httpClient;
        $this->jsonDocumentTransformer = $jsonDocumentTransformer;
        $this->logger = new NullLogger();
    }

    /**
     * @return array
     */
    abstract protected function getEventHandlers();

    /**
     * @param DomainMessage $domainMessage
     */
    public function handle(DomainMessage $domainMessage)
    {
        $handlers = $this->getEventHandlers();

        $payload = $domainMessage->getPayload();
        $payloadType = get_class($payload);

        if (array_key_exists($payloadType, $handlers) &&
            method_exists($this, $handlers[$payloadType])) {
            $handler = $handlers[$payloadType];
            $this->{$handler}($payload);
        }
    }

    /**
     * @param string $documentId
     * @param string $documentIri
     */
    protected function index($documentId, $documentIri)
    {
        $response = $this->httpClient->request('GET', $documentIri);

        if ($response->getStatusCode() == 200) {
            $jsonLd = $response->getBody();

            $jsonDocument = new JsonDocument(
                $documentId,
                $jsonLd
            );

            $jsonDocument = $this->jsonDocumentTransformer
                ->transformForIndexation($jsonDocument);

            $this->searchRepository->save($jsonDocument);
        } else {
            $this->logger->error(
                'Could not retrieve JSON-LD from url for indexation.',
                [
                    'id' => $documentId,
                    'url' => $documentIri,
                    'response' => $response
                ]
            );
        }
    }

    /**
     * @param string $documentId
     */
    protected function remove($documentId)
    {
        $this->searchRepository->remove($documentId);
    }
}
