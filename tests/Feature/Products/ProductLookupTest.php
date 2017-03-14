<?php


namespace Tests\Feature\Products;


use App\Products\FakeLookup;
use Illuminate\Foundation\Testing\DatabaseMigrations;
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
        $response->assertExactJson([
            'itemid'      => 'TEST123',
            'title'       => 'Fake title',
            'link'        => 'Fake link',
            'description' => 'Fake description',
            'image'       => 'Fake image',
            'price'       => 'Fake price'
        ]);
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