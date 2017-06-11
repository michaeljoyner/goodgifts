<?php


namespace Tests\Unit\Issues;


use App\Issues\Issue;
use App\Issues\UnavailableProductIssue;
use App\Products\Product;
use Carbon\Carbon;
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

    /**
     *@test
     */
    public function older_issues_with_the_sam_product_can_be_pruned_out()
    {
        $product = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();
        $product3 = factory(Product::class)->create();

        foreach(range(1,4) as $index) {
            $issue = Issue::createUnavailableProductIssue('TEST', ['product_id' => $product->id]);
            if($index > 1) {
                $issue->issue->created_at = Carbon::now()->subDays($index);
                $issue->issue->save();
            }
        }

        foreach(range(1,5) as $index) {
            $issue = Issue::createUnavailableProductIssue('TEST', ['product_id' => $product2->id]);
            if($index > 1) {
                $issue->issue->created_at = Carbon::now()->subDays($index);
                $issue->issue->save();
            }
        }

        foreach(range(1,3) as $index) {
            $issue = Issue::createUnavailableProductIssue('TEST', ['product_id' => $product3->id]);
            if($index > 1) {
                $issue->issue->created_at = Carbon::now()->subDays($index);
                $issue->issue->save();
            }
        }

        UnavailableProductIssue::pruneDuplicates();

        $this->assertCount(3, UnavailableProductIssue::all());
        UnavailableProductIssue::all()->each(function($issue) {
            $this->assertTrue($issue->created_at->isToday());
        });
    }
}