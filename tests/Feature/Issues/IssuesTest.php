<?php

namespace Tests\Feature\Issues;

use App\Issues\Issue;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class IssuesTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        Notification::fake();
    }

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

    /**
     *@test
     */
    public function attempting_to_view_a_non_existent_issue_just_redirects_to_issues_page()
    {
        $response = $this->asLoggedInUser()->get('/admin/issues/44');

        $response->assertStatus(302);
        $response->assertRedirect('/admin/issues');
    }
}