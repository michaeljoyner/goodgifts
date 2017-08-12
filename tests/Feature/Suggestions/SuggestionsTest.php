<?php

namespace Tests\Feature\Suggestions;

use App\Articles\Article;
use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SuggestionsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function suggestions_can_be_searched_for_by_tag()
    {
        $this->disableExceptionHandling();
        $article = factory(Article::class)->create();
        $productA = factory(Product::class)->create();
        $productB = factory(Product::class)->create();
        $productC = factory(Product::class)->create();
        $productA->setTags(['FIND_ME']);
        $productB->setTags(['DONT_FIND_ME']);
        $productC->setTags(['FIND_ME']);
        $article->attachProducts(collect([$productA->id, $productB->id, $productC->id]));
        $article = $article->fresh();
        $article->products()->updateExistingPivot($productA->id, ['what' => 'A test product', 'why' => 'why not?']);
        $article->products()->updateExistingPivot($productB->id, ['what' => 'A test product', 'why' => 'why not?']);
        $article->products()->updateExistingPivot($productC->id, ['what' => 'A test product', 'why' => 'why not?']);

        $response = $this->asLoggedInUser()->json('POST', 'admin/services/suggestions/search/tags', [
            'tags' => ['FIND_ME']
        ]);
        $response->assertStatus(200);
        $matches = $response->decodeResponseJson();

        $this->assertCount(2, $matches);
        $this->assertContains($productA->id, collect($matches)->pluck('product_id')->all());
        $this->assertContains($productC->id, collect($matches)->pluck('product_id')->all());
        $this->assertNotContains($productB->id, collect($matches)->pluck('product_id')->all());
    }

    /**
     *@test
     */
    public function suggestions_can_be_searched_for_by_product_name()
    {
        $this->disableExceptionHandling();
        $article = factory(Article::class)->create();
        $productA = factory(Product::class)->create(['title' => 'gorilla']);
        $productB = factory(Product::class)->create(['title' => 'chimpanzee']);
        $productC = factory(Product::class)->create(['title' => 'orangutan']);
        $article->attachProducts(collect([$productA->id, $productB->id, $productC->id]));
        $article = $article->fresh();
        $article->products()->updateExistingPivot($productA->id, ['what' => 'A test product', 'why' => 'why not?']);
        $article->products()->updateExistingPivot($productB->id, ['what' => 'A test product', 'why' => 'why not?']);
        $article->products()->updateExistingPivot($productC->id, ['what' => 'A test product', 'why' => 'why not?']);

        $response = $this->asLoggedInUser()->json('POST', 'admin/services/suggestions/search/name', [
            'name' => 'chimp'
        ]);
        $response->assertStatus(200);
        $matches = $response->decodeResponseJson();

        $this->assertCount(1, $matches);
        $this->assertContains($productB->id, collect($matches)->pluck('product_id')->all());
        $this->assertNotContains($productA->id, collect($matches)->pluck('product_id')->all());
        $this->assertNotContains($productC->id, collect($matches)->pluck('product_id')->all());
    }
}