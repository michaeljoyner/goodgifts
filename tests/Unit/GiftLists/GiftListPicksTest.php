<?php


namespace Tests\Unit\GiftLists;


use App\GiftLists\GiftList;
use App\Suggestions\Suggestion;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class GiftListPicksTest extends TestCase
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
    public function a_list_can_mark_a_suggestion_as_a_top_pick()
    {
        $list = factory(GiftList::class)->create();
        $suggestion = factory(Suggestion::class)->create();
        $pick = $list->addSuggestion($suggestion);

        $list->makeSuggestionTopPick($suggestion->id);

        $this->assertTrue($pick->fresh()->top_pick);
    }
}