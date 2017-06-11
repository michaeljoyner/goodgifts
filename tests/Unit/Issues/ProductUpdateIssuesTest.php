<?php


namespace Tests\Unit\Issues;


use App\Issues\BatchUpdateIssue;
use App\Issues\IncompleteUpdateIssue;
use App\Products\Product;
use Carbon\Carbon;
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

    /**
     *@test
     */
    public function batch_update_issues_older_than_a_given_number_of_hours_can_be_deleted()
    {
        foreach(range(1,5) as $index) {
            $issue = BatchUpdateIssue::create(['product_ids' => '1,2,3']);
            $issue->created_at = Carbon::now()->subHours($index * 5);
            $issue->save();
        }

        BatchUpdateIssue::clearOlderThan(12);

        $this->assertCount(2, BatchUpdateIssue::all());
        BatchUpdateIssue::all()->each(function($issue) {
            $this->assertTrue($issue->created_at->gt(Carbon::now()->subHours(12)));
        });
    }

    /**
     *@test
     */
    public function incomplete_update_issues_older_than_a_given_number_of_hours_can_be_deleted()
    {
        foreach(range(1,5) as $index) {
            $issue = IncompleteUpdateIssue::create(['product_ids' => '1,2,3']);
            $issue->created_at = Carbon::now()->subHours($index * 5);
            $issue->save();
        }

        IncompleteUpdateIssue::clearOlderThan(12);

        $this->assertCount(2, IncompleteUpdateIssue::all());
        IncompleteUpdateIssue::all()->each(function($issue) {
            $this->assertTrue($issue->created_at->gt(Carbon::now()->subHours(12)));
        });
    }


}