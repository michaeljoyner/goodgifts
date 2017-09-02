<?php


namespace Tests\Feature\GiftLists;


use App\GiftLists\GiftList;
use App\Suggestions\Suggestion;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TopPicksTest extends TestCase
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
    public function a_pick_can_be_marked_as_top_pick()
    {
        $this->disableExceptionHandling();

        $list = factory(GiftList::class)->create();
        $suggestion = factory(Suggestion::class)->create();
        $pick = $list->addSuggestion($suggestion);

        $response = $this->asLoggedInUser()->json('POST', '/admin/top-picks', [
            'pick_id' => $pick->id
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('gift_list_suggestion', [
            'top_pick' => true,
            'gift_list_id' => $list->id,
            'suggestion_id' => $suggestion->id
        ]);
    }

    /**
     *@test
     */
    public function storing_a_top_pick_successfully_returns_the_pick_id_and_top_pick_status()
    {
        $this->disableExceptionHandling();

        $list = factory(GiftList::class)->create();
        $suggestion = factory(Suggestion::class)->create();
        $pick = $list->addSuggestion($suggestion);

        $response = $this->asLoggedInUser()->json('POST', '/admin/top-picks', [
            'pick_id' => $pick->id
        ]);
        $response->assertStatus(200);
        $this->assertEquals(['pick_id' => $pick->id, 'top_pick' => true], $response->decodeResponseJson());
    }

    /**
     *@test
     */
    public function a_top_pick_can_be_removed_making_it_just_a_normal_pick()
    {
        $this->disableExceptionHandling();

        $list = factory(GiftList::class)->create();
        $suggestion = factory(Suggestion::class)->create();
        $pick = $list->addSuggestion($suggestion);
        $list->makeSuggestionTopPick($suggestion->id);

        $response = $this->asLoggedInUser()->json('DELETE', '/admin/top-picks/' . $pick->id);
        $response->assertStatus(200);

        $this->assertDatabaseHas('gift_list_suggestion', [
            'top_pick' => false,
            'gift_list_id' => $list->id,
            'suggestion_id' => $suggestion->id
        ]);
    }
}