<?php


namespace Tests\Unit\GiftLists;


use App\Articles\Article;
use App\GiftLists\GiftList;
use App\GiftLists\Pick;
use App\Products\Product;
use App\Recommendations\Request;
use App\Suggestions\Suggestion;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class GiftListsTest extends TestCase
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
    public function a_gift_list_can_get_the_suggestions_based_on_its_requests_interests()
    {
        $article = factory(Article::class)->create();
        $productA = factory(Product::class)->create();
        $productB = factory(Product::class)->create();
        $productA->setTags(['laptops']);
        $productB->setTags(['watch']);
        $article->attachProducts(collect([$productA->id, $productB->id]));
        $article = $article->fresh();
        $article->products()->updateExistingPivot($productA->id, ['what' => 'A test product', 'why' => 'why not?']);
        $article->products()->updateExistingPivot($productB->id, ['what' => 'A test product', 'why' => 'why not?']);
        $recommendation_request = factory(Request::class)->create(['interests' => 'laptops, computers']);
        $list = factory(GiftList::class)->create(['request_id' => $recommendation_request->id]);

        $suggestions = $list->defaultSuggestions();

        $this->assertCount(1, $suggestions);
        $this->assertEquals($productA->id, $suggestions->first()->product->id);
    }

    /**
     *@test
     */
    public function it_has_a_suggestion_list_of_all_attached_suggestions_with_product()
    {
        $list = factory(GiftList::class)->create();
        $suggestions = factory(Suggestion::class, 3)->create();
        $suggestions->each(function($suggestion) use ($list) {
            $list->addSuggestion($suggestion);
        });

        $listed_suggestions = $list->suggestionList();

        $this->assertCount(3, $listed_suggestions);
        collect($listed_suggestions)->each(function($suggestion) {
            $this->assertArrayHasKey('product', $suggestion);
        });
    }

    /**
     *@test
     */
    public function a_gift_list_can_be_approved()
    {
        $list = factory(GiftList::class)->create(['approved' => false]);
        $this->assertFalse($list->approved);

        $list->approve();

        $this->assertTrue($list->fresh()->approved);
    }

    /**
     *@test
     */
    public function a_list_has_a_null_slug_by_default()
    {
        $list = factory(GiftList::class)->create(['approved' => false]);

        $this->assertNull($list->slug);
    }

    /**
     *@test
     */
    public function an_approved_article_has_a_unique_slug()
    {
        $list = factory(GiftList::class)->create(['approved' => false]);
        $list->approve();

        $identifier = $list->fresh()->slug;
        $this->assertNotNull($identifier);
    }

    /**
     *@test
     */
    public function a_gift_list_can_be_fetched_by_its_slug()
    {
        $list = factory(GiftList::class)->create(['approved' => false]);
        $list->approve();
        $slug = $list->fresh()->slug;

        $fetched = GiftList::withSlug($slug);

        $this->assertTrue($list->is($fetched));
    }

    /**
     *@test
     */
    public function gift_lists_can_be_scoped_to_urgent_which_means_will_be_sent_within_a_week()
    {
        $requestA = factory(Request::class)->create(['birthday' => Carbon::parse('+23 days')->format('m-d')]);
        $requestB = factory(Request::class)->create(['birthday' => Carbon::parse('+26 days')->format('m-d')]);
        $requestC = factory(Request::class)->create(['birthday' => Carbon::parse('+32 days')->format('m-d')]);

        $requestA->createGiftList();
        $requestB->createGiftList();
        $requestC->createGiftList();

        $urgent = GiftList::urgent()->get();

        $this->assertCount(2, $urgent);
        $this->assertContains($requestA->id, $urgent->pluck('request_id')->all());
        $this->assertContains($requestB->id, $urgent->pluck('request_id')->all());
        $this->assertNotContains($requestC->id, $urgent->pluck('request_id')->all());
    }

    /**
     *@test
     */
    public function gift_lists_can_be_scoped_to_upcoming_which_is_not_urgent_but_within_the_next_five_weeks()
    {
        $requestA = factory(Request::class)->create(['birthday' => Carbon::parse('+23 days')->format('m-d')]);
        $requestB = factory(Request::class)->create(['birthday' => Carbon::parse('+36 days')->format('m-d')]);
        $requestC = factory(Request::class)->create(['birthday' => Carbon::parse('+42 days')->format('m-d')]);
        $requestD = factory(Request::class)->create(['birthday' => Carbon::parse('+92 days')->format('m-d')]);

        $requestA->createGiftList();
        $requestB->createGiftList();
        $requestC->createGiftList();
        $requestD->createGiftList();

        $urgent = GiftList::upcoming()->get();

        $this->assertCount(2, $urgent);
        $this->assertNotContains($requestA->id, $urgent->pluck('request_id')->all());
        $this->assertContains($requestB->id, $urgent->pluck('request_id')->all());
        $this->assertContains($requestC->id, $urgent->pluck('request_id')->all());
        $this->assertNotContains($requestD->id, $urgent->pluck('request_id')->all());
    }

    /**
     *@test
     */
    public function gift_lists_can_be_scoped_to_outstanding_meaning_the_birthday_has_not_passed_and_the_list_is_unsent()
    {
        $requestA = factory(Request::class)->create(['birthday' => Carbon::parse('-20 days')]);
        $requestB = factory(Request::class)->create(['birthday' => Carbon::parse('-3 days')]);
        $requestC = factory(Request::class)->create(['birthday' => Carbon::parse('+42 days')]);
        $requestD = factory(Request::class)->create(['birthday' => Carbon::parse('+92 days')]);
        $requestE = factory(Request::class)->create(['birthday' => Carbon::parse('+92 days')]);

        $requestA->createGiftList();
        $requestB->createGiftList();
        $requestC->createGiftList();
        $requestD->createGiftList();
        $sent = $requestE->createGiftList();
        $sent->update(['sent' => true]);

        $outstanding = GiftList::outstanding()->get();

        $this->assertCount(2, $outstanding);
        $this->assertNotContains($requestA->id, $outstanding->pluck('request_id')->all());
        $this->assertNotContains($requestB->id, $outstanding->pluck('request_id')->all());
        $this->assertContains($requestC->id, $outstanding->pluck('request_id')->all());
        $this->assertContains($requestD->id, $outstanding->pluck('request_id')->all());
    }

    /**
     *@test
     */
    public function lists_can_be_scoped_as_due_which_means_they_are_unsent_approved_and_due()
    {
        $requestA = factory(Request::class)->create(['birthday' => Carbon::parse('-3 days')]);
        $requestB = factory(Request::class)->create(['birthday' => Carbon::parse('+3 days')]);
        $requestC = factory(Request::class)->create(['birthday' => Carbon::parse('+20 days')]);
        $requestD = factory(Request::class)->create(['birthday' => Carbon::parse('+22 days')]);
        $requestE = factory(Request::class)->create(['birthday' => Carbon::parse('+20 days')]);
        $requestF = factory(Request::class)->create(['birthday' => Carbon::parse('+20 days')]);

        $listA = $requestA->createGiftList();
        $listB = $requestB->createGiftList();
        $listC = $requestC->createGiftList();
        $listD = $requestD->createGiftList();
        $listE = $requestD->createGiftList();
        $listF = $requestD->createGiftList();

        collect([$listA, $listB, $listC, $listD])->each(function($list) {
            $list->approved = true;
            $list->sent = false;
            $list->save();
        });

        $listE->update(['approved' => true, 'sent' => false]);
        $listF->update(['approved' => false, 'sent' => true]);



        $due = GiftList::due()->get();

        $this->assertCount(2, $due);
        $this->assertNotContains($requestA->id, $due->pluck('request_id')->all());
        $this->assertContains($requestB->id, $due->pluck('request_id')->all());
        $this->assertContains($requestC->id, $due->pluck('request_id')->all());
        $this->assertNotContains($requestD->id, $due->pluck('request_id')->all());
        $this->assertNotContains($requestE->id, $due->pluck('request_id')->all());
        $this->assertNotContains($requestF->id, $due->pluck('request_id')->all());
    }

    /**
     *@test
     */
    public function a_list_can_query_its_top_picks()
    {
        $list = factory(GiftList::class)->create();
        $top_picks = factory(Pick::class, 3)->create(['gift_list_id' => $list->id, 'top_pick' => true]);
        $other_picks = factory(Pick::class, 5)->create(['gift_list_id' => $list->id, 'top_pick' => false]);

        $topPicks = $list->topPicks();

        $this->assertCount(3, $topPicks);
        $topPicks->each(function($pick) use ($top_picks) {
            $this->assertTrue($top_picks->contains($pick));
        });
    }

    /**
     *@test
     */
    public function a_list_with_no_top_picks_marked_will_return_three_random_picks()
    {
        $list = factory(GiftList::class)->create();
        $picks = factory(Pick::class, 6)->create(['gift_list_id' => $list->id, 'top_pick' => false]);

        $topPicks = $list->topPicks();

        $this->assertCount(3, $topPicks);
        $topPicks->each(function($pick) use ($picks) {
            $this->assertTrue($picks->contains($pick));
        });
    }

    /**
     *@test
     */
    public function a_list_can_tell_how_many_top_picks_it_has()
    {
        $list = factory(GiftList::class)->create();
        factory(Pick::class, 3)->create(['gift_list_id' => $list->id, 'top_pick' => true]);
        factory(Pick::class, 5)->create(['gift_list_id' => $list->id, 'top_pick' => false]);

        $this->assertEquals(3, $list->topPickCount());
    }

}