<?php


namespace Tests\Unit\Issues;


use App\Events\IssueDeleted;
use App\Issues\ArticleUpdateIssue;
use App\Issues\BatchUpdateIssue;
use App\Issues\IncompleteUpdateIssue;
use App\Issues\Issue;
use App\Issues\UnavailableProductIssue;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class IssuesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function it_can_create_and_relate_to_a_batch_update_issue()
    {
        $issue = Issue::createBatchUpdateIssue('Batch failed to update', ['product_ids' => '1,2,3']);

        $this->assertCount(1, BatchUpdateIssue::all());
        $this->assertEquals('1,2,3', BatchUpdateIssue::first()->product_ids);
        $this->assertEquals('Batch failed to update', $issue->message);
        $this->assertEquals(BatchUpdateIssue::first()->id, $issue->issue->id);
    }

    /**
     *@test
     */
    public function it_can_create_and_relate_to_an_incomplete_lookup_issue()
    {
        $issue = Issue::createIncompleteUpdateIssue('Some products never made it back', ['product_ids' => '1,2,3']);

        $this->assertCount(1, IncompleteUpdateIssue::all());
        $this->assertEquals('1,2,3', IncompleteUpdateIssue::first()->product_ids);
        $this->assertEquals('Some products never made it back', $issue->message);
        $this->assertEquals(IncompleteUpdateIssue::first()->id, $issue->issue->id);
    }

    /**
     *@test
     */
    public function it_can_create_and_relate_to_an_unavailable_product_issue()
    {
        $issue = Issue::createUnavailableProductIssue('This product is no longer available', ['product_id' => 1]);

        $this->assertCount(1, UnavailableProductIssue::all());
        $this->assertEquals(1, UnavailableProductIssue::first()->product_id);
        $this->assertEquals('This product is no longer available', $issue->message);
        $this->assertEquals(UnavailableProductIssue::first()->id, $issue->issue->id);
    }

    /**
     *@test
     */
    public function it_can_create_and_relate_to_an_article_update_issue()
    {
        $issue = Issue::createArticleUpdateIssue('Failed to update article', ['product_id' => 1, 'article_id' => 1]);

        $this->assertCount(1, ArticleUpdateIssue::all());
        $this->assertEquals(1, ArticleUpdateIssue::first()->product_id);
        $this->assertEquals(1, ArticleUpdateIssue::first()->article_id);
        $this->assertEquals('Failed to update article', $issue->message);
        $this->assertEquals(ArticleUpdateIssue::first()->id, $issue->issue->id);
    }



    /**
     *@test
     */
    public function deleting_an_issue_also_deletes_the_underlying_issue()
    {
        $issue = Issue::createArticleUpdateIssue('Failed to update article', ['product_id' => 1, 'article_id' => 1]);
        $this->assertCount(1, Issue::all());
        $this->assertCount(1, ArticleUpdateIssue::all());

        $issue->delete();

        $this->assertCount(0, Issue::all());
        $this->assertCount(0, ArticleUpdateIssue::all());
    }

    /**
     *@test
     */
    public function a_sub_issue_can_be_resolved()
    {
        $issue = Issue::createArticleUpdateIssue('Failed to update article', ['product_id' => 1, 'article_id' => 1]);
        $subIssue = $issue->issue;
        $this->assertInstanceOf(ArticleUpdateIssue::class, $subIssue);

        $subIssue->resolve();

        $this->assertCount(0, Issue::all());
        $this->assertCount(0, ArticleUpdateIssue::all());
    }


}