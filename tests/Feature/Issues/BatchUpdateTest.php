<?php


namespace Tests\Feature\Issues;


use App\Issues\Issue;
use App\Products\FakeLookup;
use App\Products\Lookup;
use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BatchUpdateTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_batch_update_from_an_issue_can_be_retried()
    {
        $this->disableExceptionHandling();
        $this->app->bind(Lookup::class, function() {
            return new FakeLookup();
        });

        $products = collect(range(1,9))->map(function($index) {
            return factory(Product::class)->create(['itemid' => 'B00000000' . $index]);
        });

        $issue = Issue::createBatchUpdateIssue('Batch Failed', [
            'product_ids' => implode(',', $products->pluck('id')->toArray())
        ]);

        $response = $this->asLoggedInUser()->post('/admin/issues/batchupdate/' . $issue->id . '/resolve');
        $response->assertStatus(302);

        $products->each(function($product) {
            $this->assertEquals('Fake title', $product->fresh()->title);
        });
    }
}