<?php


namespace Tests\Feature\Tags;


use App\Products\Product;
use App\Tags\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TagsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function tags_can_be_added_to_a_product()
    {
        $this->disableExceptionHandling();
        $product = factory(Product::class)->create();

        $response = $this->asLoggedInUser()
            ->json('PUT', '/admin/products/' . $product->id . '/tags', ['tags' => ['TEST_1', 'TEST_2']]);
        $response->assertStatus(200);
        $this->assertEquals(['TEST_1', 'TEST_2'], $response->decodeResponseJson());

        $this->assertDatabaseHas('tags', ['tag' => 'TEST_1']);
        $this->assertDatabaseHas('tags', ['tag' => 'TEST_2']);

        $this->assertDatabaseHas('product_tag',
            ['product_id' => $product->id, 'tag_id' => Tag::where('tag', 'TEST_1')->first()->id]);
        $this->assertDatabaseHas('product_tag',
            ['product_id' => $product->id, 'tag_id' => Tag::where('tag', 'TEST_1')->first()->id]);
    }

    /**
     *@test
     */
    public function a_list_of_all_tags_can_be_fetched_with_their_product_counts()
    {
        $this->disableExceptionHandling();
        $productA = factory(Product::class)->create();
        $productB = factory(Product::class)->create();
        $productC = factory(Product::class)->create();
        $tagA = factory(Tag::class)->create();
        $tagB = factory(Tag::class)->create();
        $tagC = factory(Tag::class)->create();
        $tagD = factory(Tag::class)->create();

        $productA->tags()->attach($tagA->id);
        $productA->tags()->attach($tagB->id);
        $productB->tags()->attach($tagB->id);
        $productC->tags()->attach($tagB->id);
        $productC->tags()->attach($tagC->id);
        $productA->tags()->attach($tagC->id);
        $productC->tags()->attach($tagD->id);


        $response = $this->asLoggedInUser()->json('GET', '/admin/tags');
        $response->assertStatus(200);
        $fetched_tags = $response->decodeResponseJson();

        $expected = [
            ['id' => $tagA->id, 'name' => $tagA->tag, 'product_count' => 1],
            ['id' => $tagB->id, 'name' => $tagB->tag, 'product_count' => 3],
            ['id' => $tagC->id, 'name' => $tagC->tag, 'product_count' => 2],
            ['id' => $tagD->id, 'name' => $tagD->tag, 'product_count' => 1],
        ];

        $this->assertEquals($expected, $fetched_tags);
    }

    /**
     *@test
     */
    public function multiple_tags_can_be_deleted()
    {
        $this->disableExceptionHandling();
        $tags = factory(Tag::class, 5)->create();

        $response = $this->asLoggedInUser()->json('POST', '/admin/services/tags/deleted', [
            'tags' => $tags->pluck('id')->all()
        ]);
        $response->assertStatus(200);

        $tags->each(function($tag) {
            $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
        });
    }
}