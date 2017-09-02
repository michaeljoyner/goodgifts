<?php


namespace Tests\Unit\GiftLists;


use App\GiftLists\GiftList;
use App\GiftLists\Pick;
use App\Suggestions\Suggestion;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class GiftListSuggestionsTest extends TestCase
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
    public function a_suggestion_can_be_added_to_a_gift_list()
    {
        $list = factory(GiftList::class)->create();
        $suggestion = factory(Suggestion::class)->create();

        $pick = $list->addSuggestion($suggestion);

        $this->assertInstanceOf(Pick::class, $pick);
        $this->assertEquals($list->id, $pick->gift_list_id, 'does not have list id');
        $this->assertEquals($suggestion->id, $pick->suggestion_id, 'does not have suggestion id');
        $this->assertFalse($pick->top_pick);

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