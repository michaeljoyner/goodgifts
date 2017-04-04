<?php


namespace Tests\Unit\Issues;


use App\Issues\UnavailableProductIssue;
use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UnavailableProductIssuesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function an_unavailable_product_issue_belongs_to_a_product()
    {
        $product = factory(Product::class)->create();
        $issue = UnavailableProductIssue::create(['product_id' => $product->id]);

        $this->assertEquals($product->id, $issue->product->id);
    }
}