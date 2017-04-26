<?php


namespace Tests\Feature\Articles;


use App\Articles\Article;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ArticleDatesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function saving_the_article_content_updates_the_articles_body_updated_at_value()
    {
        $article = factory(Article::class)->create([
            'body_updated_on' => Carbon::parse('-5 days')->format('Y-m-d'),
        ]);

        $response = $this->asLoggedInUser()
            ->patch('/admin/articles/' . $article->id . '/body', ['body' => 'A sexy new body']);

        $response->assertStatus(200);

        $this->assertTrue($article->fresh()->body_updated_on->isToday());
    }
}