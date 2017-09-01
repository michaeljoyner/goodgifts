<?php


namespace Tests\Feature\Articles;


use App\Articles\Article;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ArticlePublishingTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function an_unpublished_article_is_correctly_published()
    {
        $article = factory(Article::class)->create(['published' => false, 'published_on' => null]);

        $response = $this->asLoggedInUser()->post('/admin/articles/' . $article->id . '/publish', ['publish' => true]);

        $response->assertStatus(200);
        $response->assertJson(['published' => true, 'published_on' => Carbon::now()->format('Y-m-d')]);

        $this->assertTrue($article->fresh()->published);
        $this->assertTrue($article->fresh()->published_on->isToday());
    }

    /**
     * @test
     */
    public function a_published_article_is_correctly_unpublished()
    {
        $article = factory(Article::class)->create(['published' => true, 'published_on' => Carbon::parse('-30 days')]);

        $response = $this->asLoggedInUser()->post('/admin/articles/' . $article->id . '/publish', ['publish' => false, 'published_on' => Carbon::parse('-30 days')->format('Y-m-d')]);

        $response->assertStatus(200);
        $response->assertJson(['published' => false, 'published_on' => Carbon::parse('-30 days')->format('Y-m-d')]);

        $this->assertFalse($article->fresh()->published);
    }

    /**
     * @test
     */
    public function the_publish_field_is_required()
    {
        $article = factory(Article::class)->create();

        $response = $this->asLoggedInUser()->json('POST', '/admin/articles/' . $article->id . '/publish', []);

        $response->assertStatus(422);
        $this->assertArrayHasKey('publish', $response->decodeResponseJson()['errors']);

    }

    /**
     * @test
     */
    public function providing_a_valid_date_will_set_the_published_on_date()
    {
        $article = factory(Article::class)->create(['published' => false, 'published_on' => null]);

        $response = $this->asLoggedInUser()
            ->json('POST', '/admin/articles/' . $article->id . '/publish', [
                'publish'      => true,
                'published_on' => Carbon::parse('+7 days')->format('Y-m-d')
            ]);

        $response->assertStatus(200);
        $response->assertJson(['published' => true, 'published_on' => Carbon::parse('+7 days')->format('Y-m-d')]);

        $this->assertTrue($article->fresh()->published);
        $this->assertTrue($article->fresh()->published_on->isFuture());
        $this->assertFalse($article->fresh()->isPublished());
    }

    /**
     *@test
     */
    public function published_on_field_must_be_a_valid_date()
    {
        $article = factory(Article::class)->create(['published' => false, 'published_on' => null]);

        $response = $this->asLoggedInUser()
            ->json('POST', '/admin/articles/' . $article->id . '/publish', [
                'publish'      => true,
                'published_on' => 'NOT A DATE'
            ]);

        $response->assertStatus(422);
        $this->assertArrayHasKey('published_on', $response->decodeResponseJson()['errors']);

    }
}