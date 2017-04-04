<?php


namespace Tests\Unit\Products;


use App\Products\FailingLookup;
use Tests\TestCase;

class FailingLookupTest extends TestCase
{
    /**
     * @test
     */
    public function a_failing_lookup_will_throw_an_exception_when_withid_is_called()
    {
        $lookup = new FailingLookup();

        try {
            $lookup->withId('TESTID');
        } catch (\Exception $e) {
            $this->assertEquals('Failed product lookup from failing lookup', $e->getMessage());
            return;
        }

        $this->fail('Exception was expected, but not encountered');
    }
}