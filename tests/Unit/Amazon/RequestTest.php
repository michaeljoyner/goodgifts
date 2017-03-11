<?php

namespace Tests\Unit\Amazon;

use Tests\TestCase;

class RequestTest extends TestCase
{
    /**
     * @test
     */
    public function it_correctly_generates_a_correctly_signed_request_url()
    {
        $timestamp = '2014-08-18T17:36:55.000Z';
        $params = [
            'Operation' => ['ItemSearch', 'CartCreate'],
            'Item.1.OfferListingId' => 'j8ejq9wxDfSYWf2OCp6XQGDsVrWhl08GSQ9m5j%2Be8MS449BN1XGUC3DfU5Zw4nt%2FFBt87cspLow1QXzfvZpvzg%3D%3D',
            'Item.1.Quantity' => '3',
        ];

        $request = $this->makeRequest();
        $request->usingTimestamp($timestamp);

        $expected = 'http://webservices.amazon.com/onca/xml?AWSAccessKeyId=AKIAIOSFODNN7EXAMPLE&AssociateTag=mytag-20&Item.1.OfferListingId=j8ejq9wxDfSYWf2OCp6XQGDsVrWhl08GSQ9m5j%2Be8MS449BN1XGUC3DfU5Zw4nt%2FFBt87cspLow1QXzfvZpvzg%3D%3D&Item.1.Quantity=3&Operation=CartCreate&Operation=ItemSearch&Service=AWSECommerceService&Timestamp=2014-08-18T17%3A36%3A55.000Z&Version=2013-08-01&Signature=LpEUnc9tT4WGneeUwH0LvwxLLfbMEXgmjGX5GXQ1MEQ%3D';

        $this->assertEquals($expected, $request->url($params));
    }

    /**
     *@test
     */
    public function it_uses_a_correctly_formed_timestamp()
    {
        $request = new \App\Amazon\Request("1234567890", $this->basicParams());
        $this->assertRegExp('/[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}\%3A[0-9]{2}\%3A[0-9]{2}\.[0-9]{3}Z/', $request->url());
    }

    /**
     *@test
     */
    public function the_region_may_be_supplied()
    {
        $request = new \App\Amazon\Request("1234567890", $this->basicParams(), 'co.uk');
        $this->assertContains('http://webservices.amazon.co.uk', $request->url());
    }

    /**
     *@test
     */
    public function it_correctly_signs_the_request_for_a_non_com_request()
    {
        $timestamp = '2014-08-18T17:34:34.000Z';

        $params = [
            'Operation' => ['ItemSearch', 'ItemSearch'],
            'Actor' => 'Johnny Depp',
            'ResponseGroup' => 'ItemAttributes,Offers,Images,Reviews,Variations',
            'SearchIndex' => 'DVD',
            'Sort' => 'salesrank',
        ];

        $expected = 'http://webservices.amazon.co.uk/onca/xml?AWSAccessKeyId=AKIAIOSFODNN7EXAMPLE&Actor=Johnny%20Depp&AssociateTag=mytag-20&Operation=ItemSearch&Operation=ItemSearch&ResponseGroup=ItemAttributes%2COffers%2CImages%2CReviews%2CVariations&SearchIndex=DVD&Service=AWSECommerceService&Sort=salesrank&Timestamp=2014-08-18T17%3A34%3A34.000Z&Version=2013-08-01&Signature=Gv4kWyAAD3xgSGI86I4qZ1zIjAhZYs2H7CRTpeHLD1o%3D';

        $request = $this->makeRequest('co.uk');
        $request->usingTimestamp($timestamp);

        $this->assertEquals($expected, $request->url($params));
    }

    protected function makeRequest($region = 'com')
    {
        return new \App\Amazon\Request("1234567890", [
            'Service' => 'AWSECommerceService',
            'AWSAccessKeyId' => 'AKIAIOSFODNN7EXAMPLE',
            'Version' => '2013-08-01',
            'AssociateTag' => 'mytag-20'
        ], $region);
    }

    protected function basicParams()
    {
        return [
            'Service' => 'AWSECommerceService',
            'Operation' => ['ItemSearch', 'CartCreate'],
            'AWSAccessKeyId' => 'AKIAIOSFODNN7EXAMPLE',
            'Version' => '2013-08-01',
            'AssociateTag' => 'mytag-20'
        ];
    }
}