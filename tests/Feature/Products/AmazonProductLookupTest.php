<?php


namespace Tests\Feature\Products;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AmazonProductLookupTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     * @group integration
     */
    public function a_product_may_be_looked_up_from_amazon_using_the_url_as_an_item_id()
    {
        //url for Murder of Roger Ackroyd by Agatha Christie on Amazon. Changes to product can break test
        $url = 'https://www.amazon.com/Murder-Roger-Ackroyd-Hercule-Mysteries/dp/0062073567/';

        $response = $this->asLoggedInUser()->json('POST', '/admin/services/products/lookup', ['itemid' => $url]);

        $response->assertStatus(200);
        $product = $response->decodeResponseJson();

        $this->assertContains('Ackroyd', $product['title']);
        $this->assertContains($product['itemid'], $url);
    }
}