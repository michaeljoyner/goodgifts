<?php


namespace Tests\Unit\Tags;


use App\Products\Product;
use App\Tags\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProductTagsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_set_of_tags_can_be_added_to_a_product()
    {
        $tags = ['tag 1', 'tag 2', 'tag 3'];
        $product = factory(Product::class)->create();

        $product->setTags($tags);

        $this->assertCount(3, $product->fresh()->tags);

        $product->fresh()->tags->each(function($tag) use ($tags) {
            $this->assertContains($tag->tag, $tags);
        });
    }

    /**
     *@test
     */
    public function setting_existing_tags_on_a_product_does_not_create_duplicate_tags()
    {
        foreach(range(1,5) as $index) {
            factory(Tag::class)->create(['tag' => 'tag ' . $index]);
        }
        $product = factory(Product::class)->create();
        $product->setTags(['tag 1', 'tag 3', 'tag 5']);

        $this->assertCount(3, $product->fresh()->tags);
        $this->assertCount(5, Tag::all());

        $product->fresh()->tags->each(function($tag) {
            $this->assertContains($tag->tag, ['tag 1', 'tag 3', 'tag 5']);
        });

    }

    /**
     *@test
     */
    public function setting_a_mixture_of_new_and_existing_tags_does_not_create_duplicate_tags()
    {
        foreach(range(1,5) as $index) {
            factory(Tag::class)->create(['tag' => 'tag ' . $index]);
        }
        $product = factory(Product::class)->create();
        $product->setTags(['tag 1', 'tag 3', 'tag 6', 'tag 7']);

        $this->assertCount(4, $product->fresh()->tags);
        $this->assertCount(7, Tag::all());

        $product->fresh()->tags->each(function($tag) {
            $this->assertContains($tag->tag, ['tag 1', 'tag 3', 'tag 6', 'tag 7']);
        });
    }
}