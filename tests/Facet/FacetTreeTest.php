<?php

namespace CultuurNet\UDB3\Search\Facet;

class FacetTreeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_has_a_multi_level_list_of_facet_node_children()
    {
        $node11 = new FacetNode('facet11', 'Facet 1.1', 3);
        $node12 = new FacetNode('facet12', 'Facet 1.2', 14);
        $node13 = new FacetNode('facet13', 'Facet 1.3', 15);

        $node1 = new FacetNode('facet1', 'Facet 1', 32, [$node11, $node12, $node13]);

        $node21 = new FacetNode('facet21', 'Facet 2.1', 7);
        $node22 = new FacetNode('facet22', 'Facet 2.2', 8);
        $node23 = new FacetNode('facet23', 'Facet 2.3', 13);

        $node2 = new FacetNode('facet2', 'Facet 2', 28, [$node21, $node22, $node23]);

        $filter = new FacetFilter('filter1', [$node1, $node2]);

        // Don't use assertEquals because we want to test that we can get all
        // required info by using the getters on the facet filter and nodes.
        $this->assertFilterEquals('filter1', [$node1, $node2], $filter);
    }

    /**
     * @param $expectedKey
     * @param array $expectedChildren
     * @param FacetFilter $actual
     */
    private function assertFilterEquals($expectedKey, array $expectedChildren, FacetFilter $actual)
    {
        $this->assertEquals($expectedKey, $actual->getKey());
        $this->assertChildrenEquals($expectedChildren, $actual->getChildren());
    }

    /**
     * @param array $expected
     * @param array $actual
     */
    private function assertChildrenEquals(array $expected, array $actual)
    {
        $this->assertEquals(count($expected), count($actual));

        for ($i = 0; $i < count($expected); $i++) {
            $this->assertNodeEquals($expected[$i], $actual[$i]);
        }
    }

    /**
     * @param FacetNode $expected
     * @param FacetNode $actual
     */
    private function assertNodeEquals(FacetNode $expected, FacetNode $actual)
    {
        $this->assertEquals($expected->getKey(), $actual->getKey());
        $this->assertEquals($expected->getLabel(), $actual->getLabel());
        $this->assertEquals($expected->getCount(), $actual->getCount());
        $this->assertChildrenEquals($expected->getChildren(), $actual->getChildren());
    }
}
