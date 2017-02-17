<?php

namespace CultuurNet\UDB3\Search\Event;

use CultuurNet\UDB3\ReadModel\JsonDocument;

class EventJsonDocumentTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EventJsonDocumentTransformer
     */
    private $transformer;

    public function setUp()
    {
        $this->transformer = new EventJsonDocumentTransformer();
    }

    /**
     * @test
     */
    public function it_transforms_location_geocoordinates_to_geojson_coordinates_on_the_event_itself()
    {
        $original = file_get_contents(__DIR__ . '/data/original-with-geocoordinates.json');
        $originalDocument = new JsonDocument('23017cb7-e515-47b4-87c4-780735acc942', $original);

        $expected = file_get_contents(__DIR__ . '/data/indexed-with-geocoordinates.json');
        $expectedDocument = new JsonDocument('23017cb7-e515-47b4-87c4-780735acc942', $expected);

        $actualDocument = $this->transformer->transformForIndexation($originalDocument);

        $this->assertJsonDocumentEquals($expectedDocument, $actualDocument);
    }

    /**
     * @param JsonDocument $expected
     * @param JsonDocument $actual
     */
    private function assertJsonDocumentEquals(JsonDocument $expected, JsonDocument $actual)
    {
        $expectedBody = $expected->getBody();
        $expectedJsonPretty = json_encode($expectedBody, JSON_PRETTY_PRINT);
        $expected = new JsonDocument($expected->getId(), $expectedJsonPretty);

        $actualBody = $actual->getBody();
        $actualJsonPretty = json_encode($actualBody, JSON_PRETTY_PRINT);
        $actual = new JsonDocument($actual->getId(), $actualJsonPretty);

        $this->assertEquals($expected, $actual);
    }
}
