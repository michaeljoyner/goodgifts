<?php

namespace Tests\Feature\Issues;

use App\Issues\Issue;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class IssuesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function an_issue_can_be_deleted()
    {
        $issue = Issue::createUnavailableProductIssue('Product unavailable', ['product_id' => 1]);

        $response = $this->asLoggedInUser()->delete('/admin/issues/' . $issue->id);
        $response->assertStatus(302);

        $this->assertDatabaseMissing('issues', ['id' => $issue->id]);
    }
}