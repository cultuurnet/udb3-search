<?php

namespace CultuurNet\UDB3\Search\Region;

class RegionNameMap
{
    /**
     * @var RegionName[]
     */
    private $map;

    /**
     * @param RegionId $regionId
     * @param RegionName $regionName
     */
    public function register(RegionId $regionId, RegionName $regionName)
    {
        $this->map[$regionId->toNative()] = $regionName;
    }

    /**
     * @param RegionId $regionId
     * @return RegionName|null
     */
    public function find(RegionId $regionId)
    {
        $regionId = $regionId->toNative();

        if (!isset($this->map[$regionId])) {
            return null;
        }

        return $this->map[$regionId];
    }
}
