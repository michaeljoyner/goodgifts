<?php


namespace Tests\Unit\GiftLists;


use App\Articles\Article;
use App\GiftLists\GiftList;
use App\Products\Product;
use App\Recommendations\Request;
use App\Suggestions\Suggestion;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GiftListsTest extends TestCase
{
    use DatabaseMigrations;

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
}