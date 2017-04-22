<?php

namespace Tests\Feature\Cards;

use App\Products\FakeProductSearch;
use App\Products\ProductSearch;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CardSearchTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function cards_can_be_searched_for_by_posting_to_endpoint()
    {
        $this->app->bind(ProductSearch::class, function() {
           return new FakeProductSearch();
        });

        $response = $this->asLoggedInUser()->get('/admin/services/cards/search?q=keyword1,keyword2');
        $response->assertStatus(200);

        $this->assertGreaterThan(1, count($response->decodeResponseJson()));
    }
}