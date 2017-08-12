<?php

namespace Tests\Feature\GiftLists;

use App\GiftLists\GiftList;
use App\Recommendations\Request;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GiftListsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_gift_list_can_be_created_for_a_request()
    {
        $this->disableExceptionHandling();
        $recommendation_request = factory(Request::class)->create();

        $response = $this
            ->asLoggedInUser()
            ->post('/admin/recommendations/' . $recommendation_request->id . '/giftlists', []);
        $response->assertStatus(302);

        $this->assertDatabaseHas('gift_lists', [
            'request_id' => $recommendation_request->id
        ]);

        $list = GiftList::where('request_id', $recommendation_request->id)->first();
        $response->assertRedirect('/admin/giftlists/' . $list->id);
    }

    /**
     *@test
     */
    public function a_list_writeup_can_be_edited()
    {
        $this->disableExceptionHandling();
        $list = factory(GiftList::class)->create(['writeup' => 'Original Writeup']);

        $response = $this->asLoggedInUser()->json('POST', '/admin/giftlists/' . $list->id, [
            'writeup' => 'A new and improved writeup'
        ]);
        $response->assertStatus(200);
        $response->assertJson(['writeup' => 'A new and improved writeup']);

        $this->assertDatabaseHas('gift_lists', [
            'id' => $list->id,
            'writeup' => 'A new and improved writeup'
        ]);
    }
}