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
        $this->disableExceptionHandling();
        //url for Murder of Roger Ackroyd by Agatha Christie on Amazon. Changes to product can break test
        $url = 'https://www.amazon.com/Murder-Roger-Ackroyd-Hercule-Mysteries/dp/0062073567/';

        $response = $this->asLoggedInUser()->json('POST', '/admin/services/products/lookup', ['itemid' => $url]);

        $response->assertStatus(200);
        $product = $response->decodeResponseJson()[0];
        $this->assertContains('Ackroyd', $product['title']);
        $this->assertContains($product['itemid'], $url);
    }

    /**
     *@test
     * @group integration
     */
    public function multiple_amazon_products_may_be_looked_up()
    {
        $this->disableExceptionHandling();
        $urls = 'https://www.amazon.com/Grave-Before-Shave-Beard-Balm/dp/B00LQD3IEU/ref=sr_1_4_s_it?s=beauty&ie=UTF8&qid=1489640971&sr=1-4&keywords=beard+balms&refinements=p_72%3A1248873011
, https://www.amazon.com/Murder-Roger-Ackroyd-Hercule-Mysteries/dp/0062073567/';

        $response = $this->asLoggedInUser()->json('POST', '/admin/services/products/lookup', ['itemid' => $urls]);

        $response->assertStatus(200);

        $results = $response->decodeResponseJson();

        $this->assertCount(2, $results);
        $this->assertArrayHasKey('title', $results[0]);
        $this->assertArrayHasKey('title', $results[1]);
        $this->assertTrue(str_contains($results[0]['title'], 'Beard') || str_contains($results[1]['title'], 'Beard'));
        $this->assertTrue(str_contains($results[0]['title'], 'Ackroyd') || str_contains($results[1]['title'], 'Ackroyd'));
    }
}