<?php


namespace Tests\Unit\GiftLists;


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
    public function a_suggestion_can_be_added_to_a_gift_list()
    {
        $list = factory(GiftList::class)->create();
        $suggestion = factory(Suggestion::class)->create();

        $list->addSuggestion($suggestion);

        $this->assertCount(1, $list->fresh()->suggestions);
        $this->assertEquals($suggestion->id, $list->fresh()->suggestions->first()->id);
    }

    /**
     *@test
     */
    public function a_suggestion_can_be_removed_from_a_gift_list()
    {
        $list = factory(GiftList::class)->create();
        $suggestion = factory(Suggestion::class)->create();
        $list->addSuggestion($suggestion);

        $list->fresh()->removeSuggestion($suggestion);

        $this->assertCount(0, $list->fresh()->suggestions);
    }
}