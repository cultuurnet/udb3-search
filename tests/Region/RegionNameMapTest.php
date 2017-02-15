<?php

namespace CultuurNet\UDB3\Search\Region;

class RegionNameMapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_can_register_multiple_region_ids_and_names_and_find_one_by_id_afterwards()
    {
        $map = new RegionNameMap();
        $map->register(new RegionId('11002'), new RegionName('Antwerpen'));
        $map->register(new RegionId('24062'), new RegionName('Leuven'));

        $expected = new RegionName('Leuven');
        $actual = $map->find(new RegionId('24062'));

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function it_returns_null_if_the_given_region_id_is_not_registered()
    {
        $map = new RegionNameMap();
        $this->assertNull($map->find(new RegionId('24062')));
    }
}
