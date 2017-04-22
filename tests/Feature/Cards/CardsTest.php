<?php


namespace Tests\Feature\Cards;


use App\Cards\Card;
use App\Products\FakeLookup;
use App\Products\Lookup;
use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CardsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->app->bind(Lookup::class, function() {
            return new FakeLookup();
        });
    }

    /**
     *@test
     */
    public function a_card_can_be_added()
    {
        $this->disableExceptionHandling();
        $response = $this->asLoggedInUser()->post('/admin/cards', [
            'itemid' => 'B00TEST00'
        ]);

        $response->assertStatus(200);

        $this->assertCount(1, Card::all());
        $this->assertEquals(Card::first()->product_id, Product::where('itemid', 'B00TEST00')->first()->id);
    }

    /**
     *@test
     */
    public function a_card_can_be_deleted()
    {
        $card = Card::create(['product_id' => 1]);
        $response = $this->asLoggedInUser()->delete('/admin/cards/' . $card->id);
        $response->assertStatus(200);

        $this->assertDatabaseMissing('cards', ['id' => $card->id]);
    }
}