<?php


namespace Tests\Feature\GiftLists;


use App\GiftLists\GiftList;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class GiftListApprovalTest extends TestCase
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
    public function a_gift_list_may_be_approved()
    {
        $this->disableExceptionHandling();
        $list = factory(GiftList::class)->create(['approved' => false]);

        $response = $this->asLoggedInUser()->post('/admin/giftlists/' . $list->id . '/approved');
        $response->assertStatus(302);
        $response->assertRedirect('/admin/giftlists');

        $this->assertDatabaseHas('gift_lists', ['id' => $list->id, 'approved' => true]);
    }
}