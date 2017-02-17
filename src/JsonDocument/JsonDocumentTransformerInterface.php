<?php

namespace CultuurNet\UDB3\Search\JsonDocument;

use CultuurNet\UDB3\ReadModel\JsonDocument;

interface JsonDocumentTransformerInterface
{
    /**
     * @param JsonDocument $jsonDocument
     * @return JsonDocument
     */
    public function transformForIndexation(JsonDocument $jsonDocument);
}
