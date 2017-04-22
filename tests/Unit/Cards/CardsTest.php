<?php


namespace Tests\Unit\Cards;


use App\Cards\Card;
use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CardsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function deleting_a_card_deletes_the_underlying_product()
    {
        $product = factory(Product::class)->create();
        $card = Card::create(['product_id' => $product->id]);

        $card->delete();

        $this->assertModelDeleted($product);
    }

    /**
     *@test
     */
    public function a_card_has_access_to_its_product()
    {
        $product = factory(Product::class)->create(['title' => 'Test Product']);
        $card = Card::create(['product_id' => $product->id]);

        $this->assertEquals('Test Product', $card->product->title);
    }
}