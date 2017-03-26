<?php


namespace Tests\Unit\Amazon;


use App\Amazon\AmazonId;
use Tests\TestCase;

class AmazonIdTest extends TestCase
{
    /**
     *@test
     */
    public function it_can_extract_an_id_from_a_url()
    {
        $url = 'https://amazon.com/a-test-product/dp/B00TEST666/go-get-me';

        $id = AmazonId::fromUrl($url);

        $this->assertEquals('B00TEST666', $id);
    }

    /**
     * @test
     */
    public function it_can_parse_string_ids()
    {
        $id = 'B99TEST999';
        $url = 'https://amazon.com/a-test-product/dp/B00TEST666/go-get-me';

        $this->assertEquals('B99TEST999', AmazonId::parse($id));
        $this->assertEquals('B00TEST666', AmazonId::parse($url));
    }
}