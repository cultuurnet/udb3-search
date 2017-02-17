<?php

namespace CultuurNet\UDB3\Search;

use CultuurNet\UDB3\ReadModel\JsonDocument;

trait AssertJsonDocumentTrait
{
    /**
     * @param \PHPUnit_Framework_TestCase $testCase
     * @param JsonDocument $expected
     * @param JsonDocument $actual
     */
    private function assertJsonDocumentEquals(
        \PHPUnit_Framework_TestCase $testCase,
        JsonDocument $expected,
        JsonDocument $actual
    ) {
        $expected = $this->convertJsonDocumentFromCompactToPrettyPrint($expected);
        $actual = $this->convertJsonDocumentFromCompactToPrettyPrint($actual);
        $testCase->assertEquals($expected, $actual);
    }

    /**
     * @param JsonDocument $jsonDocument
     * @return JsonDocument
     */
    private function convertJsonDocumentFromCompactToPrettyPrint(JsonDocument $jsonDocument)
    {
        $body = $jsonDocument->getBody();
        $jsonWithoutPrettyPrint = json_encode($body, JSON_PRETTY_PRINT);
        return new JsonDocument($jsonDocument->getId(), $jsonWithoutPrettyPrint);
    }

    /**
     * @param JsonDocument $jsonDocument
     * @return JsonDocument
     */
    private function convertJsonDocumentFromPrettyPrintToCompact(JsonDocument $jsonDocument)
    {
        $body = $jsonDocument->getBody();
        $jsonWithoutPrettyPrint = json_encode($body);
        return new JsonDocument($jsonDocument->getId(), $jsonWithoutPrettyPrint);
    }
}
