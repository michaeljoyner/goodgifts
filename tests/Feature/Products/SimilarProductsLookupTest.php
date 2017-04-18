<?php


namespace Tests\Feature\Products;


use App\Products\FakeSimilarSearch;
use App\Products\SimilarSearch;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SimilarProductsLookupTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_request_can_be_made_to_view_similar_products()
    {
        $this->disableExceptionHandling();
        $this->app->bind(SimilarSearch::class, function() {
           return new FakeSimilarSearch();
        });

        $response = $this->asLoggedInUser()->get('/admin/services/products/similar/B00TEST000');
        $response->assertStatus(200);

        $this->assertCount(10, $response->decodeResponseJson());
    }
}