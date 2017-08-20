<?php


namespace Tests\Feature\GiftLists;


use App\Recommendations\Request;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ListUnsubscribingTest extends TestCase
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
    public function by_unsubscribing_all_requests_and_gift_lists_for_that_email_are_deleted()
    {
        $this->disableExceptionHandling();
        $request = factory(Request::class)->create(['email' => 'testemail@example.com']);
        $list = $request->createGiftList();
        $list->approve();

        $response = $this->get('/lists/unsubscribe/' . $list->request->unsubscribe_token);
        $response->assertStatus(200);

        $this->assertDatabaseMissing('requests', ['email' => 'testemail@example.com']);
        $this->assertDatabaseMissing('gift_lists', ['id' => $list->id]);
    }
}