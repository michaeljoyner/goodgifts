<?php


namespace Tests\Feature\Articles;


use App\Articles\Article;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ArticlePreviewTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_logged_in_user_may_preview_unpublished_articles()
    {
        $article = factory(Article::class)->create(['published' => false]);

        $response = $this->asLoggedInUser()->get('/admin/articles/' . $article->id . '/preview');

        $response->assertStatus(200);

        $response->assertSee($article->body);
    }

    /**
     *@test
     */
    public function a_guest_user_cannot_preview_or_view_an_unpublished_article()
    {
        $article = factory(Article::class)->create(['published' => false]);

        $response = $this->get('/admin/articles/' . $article->id . '/preview');
        $response->assertRedirect('/admin/login');

        $response2 = $this->get('/articles/' . $article->slug);
        $response2->assertStatus(404);
    }
}