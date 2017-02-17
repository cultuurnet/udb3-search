<?php

namespace CultuurNet\UDB3\Search;

interface JsonDocumentIndexServiceInterface
{
    /**
     * @param string $documentId
     * @param string $documentIri
     */
    public function index($documentId, $documentIri);

    /**
     * @param string $documentId
     */
    public function remove($documentId);
}
