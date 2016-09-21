<?php

namespace CultuurNet\UDB3\Search;

use ValueObjects\Number\Natural;
use ValueObjects\String\String as StringLiteral;

class OrganizerSearchParametersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_has_configurable_start_and_limit_parameters_with_default_values()
    {
        $defaultParameters = new OrganizerSearchParameters();

        $specificParameters = $defaultParameters
            ->withStart(new Natural(20))
            ->withLimit(new Natural(10));

        $this->assertEquals(new Natural(0), $defaultParameters->getStart());
        $this->assertEquals(new Natural(30), $defaultParameters->getLimit());

        $this->assertEquals(new Natural(20), $specificParameters->getStart());
        $this->assertEquals(new Natural(10), $specificParameters->getLimit());
    }

    /**
     * @test
     */
    public function it_has_an_optional_name_parameter()
    {
        $defaultParameters = new OrganizerSearchParameters();

        $specificParameters = $defaultParameters
            ->withName(new StringLiteral('STUK'));

        $this->assertNull($defaultParameters->getName());
        $this->assertEquals(new StringLiteral('STUK'), $specificParameters->getName());
    }
}
