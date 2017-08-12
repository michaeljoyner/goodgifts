<?php


namespace Tests\Feature\GiftLists;


use App\GiftLists\GiftList;
use App\Suggestions\Suggestion;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GiftListSuggestionsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_gift_lists_suggestions_may_be_fetched()
    {
        $this->disableExceptionHandling();
        $list = factory(GiftList::class)->create();
        $suggestions = factory(Suggestion::class, 3)->create();
        $suggestions->each(function($suggestion) use ($list) {
            $list->addSuggestion($suggestion);
        });

        $response = $this
            ->asLoggedInUser()
            ->json('GET', '/admin/services/giftlists/' . $list->id . '/suggestions');
        $response->assertStatus(200);

        $fetched_suggestions = $response->decodeResponseJson();

        $this->assertCount(3, $fetched_suggestions);
        collect($fetched_suggestions)->each(function($suggestion) {
            $this->assertArrayHasKey('product', $suggestion);
        });
    }

    /**
     *@test
     */
    public function a_suggestion_can_be_added_to_a_gift_list()
    {
        $this->disableExceptionHandling();
        $list = factory(GiftList::class)->create();
        $suggestion = factory(Suggestion::class)->create();

        $response = $this
            ->asLoggedInUser()
            ->json('POST', '/admin/giftlists/' . $list->id . '/suggestions/' . $suggestion->id, []);
        $response->assertStatus(200);

        $this->assertDatabaseHas('gift_list_suggestion', [
            'gift_list_id' => $list->id,
            'suggestion_id' => $suggestion->id
        ]);
    }

    /**
     *@test
     */
    public function a_suggestion_can_be_removed_from_a_list()
    {
        $this->disableExceptionHandling();
        $list = factory(GiftList::class)->create();
        $suggestion = factory(Suggestion::class)->create();
        $list->addSuggestion($suggestion);

        $response = $this
            ->asLoggedInUser()
            ->json('DELETE', '/admin/giftlists/' . $list->id . '/suggestions/' . $suggestion->id);
        $response->assertStatus(200);

        $this->assertDatabaseMissing('gift_list_suggestion', [
            'gift_list_id' => $list->id,
            'suggestion_id' => $suggestion->id
        ]);
    }
}