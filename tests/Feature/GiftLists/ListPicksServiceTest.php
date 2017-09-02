<?php


namespace Tests\Feature\GiftLists;



use App\GiftLists\GiftList;
use App\Suggestions\Suggestion;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ListPicksServiceTest extends TestCase
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
    public function a_lists_picks_can_be_fetched_in_an_appropriate_format()
    {
        $this->disableExceptionHandling();
        $list = factory(GiftList::class)->create();
        $suggestions = factory(Suggestion::class, 10)->create();

        $picks = $suggestions->map(function($suggestion) use ($list) {
            return $list->addSuggestion($suggestion);
        });

        $response = $this->asLoggedInUser()->json('GET', '/admin/services/giftlists/' . $list->id . '/picks');
        $response->assertStatus(200);

        $fetched_picks = $response->decodeResponseJson();

        $picks->each(function($pick) use ($fetched_picks) {
            $this->assertContains($pick->toJsonableArray(), $fetched_picks);
        });
    }
}