<?php


namespace Tests\Feature\Products;


use App\Products\FakeLookup;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ProductLookupTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->app->bind(\App\Products\Lookup::class, function ($app) {
            return new FakeLookup();
        });
    }

    /**
     * @test
     */
    public function a_product_can_be_looked_up_by_posting_to_endpoint()
    {
        $response = $this->asLoggedInUser()->json('POST', '/admin/services/products/lookup', ['itemid' => 'TEST123']);

        $response->assertStatus(200);
        $results = $response->decodeResponseJson();

        $this->assertCount(1, $results);

        $this->assertContains([
            'title'       => 'Fake title',
            'link'        => 'Fake link',
            'description' => 'Fake description',
            'price'       => 'Fake price',
            'image'       => 'Fake image',
            'itemid'      => 'TEST123',
        ], $results);
    }

    /**
     *@test
     */
    public function multiple_products_can_be_looked_up()
    {
        $this->disableExceptionHandling();
        $productUrls = 'http://amazon.com/testurl-one/dp/B00TEST111/test, http://amazon.com/testurl-two/dp/B00TEST222/test';

        $response = $this->asLoggedInUser()->json('POST', '/admin/services/products/lookup', ['itemid' => $productUrls]);

        $response->assertStatus(200);
        $results = $response->decodeResponseJson();

        $this->assertCount(2, $results);
    }

    /**
     * @test
     */
    public function an_item_id_is_required_for_lookup()
    {
        $response = $this->asLoggedInUser()->json('POST', '/admin/services/products/lookup', ['itemid' => '']);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'itemid'
        ]);
    }
}