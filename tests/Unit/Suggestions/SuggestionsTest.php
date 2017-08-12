<?php

namespace Tests\Unit\Suggestions;

use App\Articles\Article;
use App\Products\Product;
use App\Suggestions\Suggestion;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SuggestionsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function suggestions_can_be_found_by_tags()
    {
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

        $matches = Suggestion::forTags(['FIND_ME']);

        $this->assertCount(2, $matches);
        $this->assertContains($productA->id, $matches->pluck('product_id')->all());
        $this->assertContains($productC->id, $matches->pluck('product_id')->all());
        $this->assertNotContains($productB->id, $matches->pluck('product_id')->all());
    }

    /**
     *@test
     */
    public function suggestions_can_be_found_based_on_product_name()
    {
        $article = factory(Article::class)->create();
        $productA = factory(Product::class)->create(['title' => 'gorilla']);
        $productB = factory(Product::class)->create(['title' => 'chimpanzee']);
        $productC = factory(Product::class)->create(['title' => 'orangutan']);
        $article->attachProducts(collect([$productA->id, $productB->id, $productC->id]));
        $article = $article->fresh();
        $article->products()->updateExistingPivot($productA->id, ['what' => 'A test product', 'why' => 'why not?']);
        $article->products()->updateExistingPivot($productB->id, ['what' => 'A test product', 'why' => 'why not?']);
        $article->products()->updateExistingPivot($productC->id, ['what' => 'A test product', 'why' => 'why not?']);

        $matches = Suggestion::byProductName('chimp');

        $this->assertCount(1, $matches);
        $this->assertContains($productB->id, $matches->pluck('product_id')->all());
        $this->assertNotContains($productA->id, $matches->pluck('product_id')->all());
        $this->assertNotContains($productC->id, $matches->pluck('product_id')->all());
    }
}