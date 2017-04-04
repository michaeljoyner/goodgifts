<?php


namespace Tests\Unit\Issues;


use App\Issues\BatchUpdateIssue;
use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProductUpdateIssuesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_product_update_issue_can_retrieve_the_associated_products()
    {
        $product1 = factory(Product::class)->create(['itemid' => 'ITEMID1']);
        $product2 = factory(Product::class)->create(['itemid' => 'ITEMID2']);

        $issue = BatchUpdateIssue::create(['product_ids' => $product1->id . ',' . $product2->id]);

        $this->assertTrue($issue->products()->contains($product1));
        $this->assertTrue($issue->products()->contains($product2));
    }
}