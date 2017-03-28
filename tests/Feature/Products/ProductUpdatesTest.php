<?php


namespace Tests\Feature\Products;


use App\Products\FakeLookup;
use App\Products\Lookup;
use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\MakesArticlesWithProducts;
use Tests\TestCase;

class ProductUpdatesTest extends TestCase
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
    public function products_may_be_updated_via_artisan_command()
    {
        factory(Product::class, 1)->create(['itemid' => 'ITEMID1']);
        factory(Product::class, 1)->create(['itemid' => 'ITEMID2']);

        Artisan::call('products:update');

        $product1 = Product::where('itemid', 'ITEMID1')->first();
        $product2 = Product::where('itemid', 'ITEMID2')->first();

        $this->assertEquals('Fake title', $product1->title);
        $this->assertEquals('Fake link', $product1->link);
        $this->assertEquals('Fake price', $product1->price);
        $this->assertEquals('Fake image', $product1->image);

        $this->assertEquals('Fake title', $product2->title);
        $this->assertEquals('Fake link', $product2->link);
        $this->assertEquals('Fake price', $product2->price);
        $this->assertEquals('Fake image', $product2->image);
    }
}