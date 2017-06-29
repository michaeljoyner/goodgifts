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
    public function a_list_of_all_tags_can_be_fetched()
    {
        $this->disableExceptionHandling();
        factory(Tag::class, 10)->create();

        $response = $this->asLoggedInUser()->json('GET', '/admin/tags');
        $response->assertStatus(200);

        $this->assertEquals(Tag::all()->map(function($tag) {
            return ['id' => $tag->id, 'name' => $tag->tag];
        })->toArray(), $response->decodeResponseJson());
    }
}