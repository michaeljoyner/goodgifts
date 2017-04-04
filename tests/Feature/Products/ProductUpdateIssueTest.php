<?php


namespace Tests\Feature\Products;


use App\Issues\BatchUpdateIssue;
use App\Issues\IncompleteUpdateIssue;
use App\Issues\UnavailableProductIssue;
use App\Products\Lookup;
use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ProductUpdateIssueTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_product_update_that_fails_on_a_batch_lookup_creates_a_batch_update_issue()
    {
        $this->app->bind(Lookup::class, function() {
            return new \App\Products\FailingLookup();
        });

        $product1 = factory(Product::class)->create(['itemid' => 'ITEMID1']);
        $product2 = factory(Product::class)->create(['itemid' => 'ITEMID2']);

        Artisan::call('products:update');

        $this->assertDatabaseHas('batch_update_issues', [
            'product_ids' => $product1->id . ',' . $product2->id
        ]);

        $this->assertCount(1, BatchUpdateIssue::all());
        $issue = BatchUpdateIssue::first();
        $this->assertTrue($issue->products()->contains($product1));
        $this->assertTrue($issue->products()->contains($product2));
    }

    /**
     *@test
     */
    public function a_product_update_that_returns_an_unavailable_product_creates_a_unavailable_product_issue()
    {
        $this->app->bind(Lookup::class, function() {
            return new \App\Products\FakeUnavailableProductLookup();
        });

        $product1 = factory(Product::class)->create(['itemid' => 'ITEMID1']);
        $product2 = factory(Product::class)->create(['itemid' => 'ITEMID2']);

        Artisan::call('products:update');

        $this->assertDatabaseHas('unavailable_product_issues', [
            'product_id' => $product1->id
        ]);
        $this->assertDatabaseHas('unavailable_product_issues', [
            'product_id' => $product2->id
        ]);

        $this->assertCount(2, UnavailableProductIssue::all());
        $issues = UnavailableProductIssue::all();
        $this->assertEquals($product1->id, $issues->first()->product->id);
        $this->assertEquals($product2->id, $issues->last()->product->id);
    }

    /**
     *@test
     */
    public function an_product_update_that_returns_an_incomplete_lookup_creates_a_incomplete_update_issue()
    {
        $this->app->bind(Lookup::class, function() {
            return new \App\Products\FakeIncompleteLookup();
        });

        foreach(range(1,10) as $index) {
            factory(Product::class)->create(['itemid' => 'ITEMID_' . $index]);
        }

        Artisan::call('products:update');

        $this->assertCount(1, IncompleteUpdateIssue::all());
        $this->assertTrue(IncompleteUpdateIssue::first()->products()->count() > 0);
    }
}