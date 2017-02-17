<?php

namespace CultuurNet\UDB3\Search;

use CultuurNet\UDB3\Event\ReadModel\DocumentRepositoryInterface;
use CultuurNet\UDB3\ReadModel\JsonDocument;
use CultuurNet\UDB3\Search\JsonDocument\JsonDocumentTransformerInterface;
use GuzzleHttp\ClientInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

class TransformingJsonDocumentIndexService implements
    JsonDocumentIndexServiceInterface,
    LoggerAwareInterface
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
     * @param ClientInterface $httpClient
     * @param JsonDocumentTransformerInterface $jsonDocumentTransformer
     * @param DocumentRepositoryInterface $searchRepository
     */
    public function __construct(
        ClientInterface $httpClient,
        JsonDocumentTransformerInterface $jsonDocumentTransformer,
        DocumentRepositoryInterface $searchRepository
    ) {
        $this->httpClient = $httpClient;
        $this->jsonDocumentTransformer = $jsonDocumentTransformer;
        $this->searchRepository = $searchRepository;
        $this->logger = new NullLogger();
    }

    /**
     * @param string $documentId
     * @param string $documentIri
     */
    public function index($documentId, $documentIri)
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
    public function remove($documentId)
    {
        $this->searchRepository->remove($documentId);
    }
}
