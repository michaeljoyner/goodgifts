<?php


namespace Tests\Unit\Articles;


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
    public function an_article_can_has_a_nullable_body_updated_at_date_field()
    {
        $article = factory(Article::class)->create(['body_updated_on' => null]);

        $this->assertNull($article->body_updated_on);
    }

    /**
     *@test
     */
    public function an_article_can_have_a_body_updated_on_value()
    {
        $article = factory(Article::class)->create(['body_updated_on' => Carbon::now()->format('Y-m-d')]);

        $this->assertTrue($article->body_updated_on->isToday());
    }

    /**
     *@test
     */
    public function the_body_updated_on_value_is_updated_by_the_setBody_method()
    {
        $article = factory(Article::class)->create(['body_updated_on' => null]);

        $article->setBody('this is the new body content');

        $this->assertTrue($article->fresh()->body_updated_on->isToday());
    }

    /**
     *@test
     */
    public function an_articles_last_updated_method_returns_the_body_updated_on_value()
    {
        $article = factory(Article::class)->create(['body_updated_on' => Carbon::now()->format('Y-m-d')]);

        $this->assertTrue($article->lastUpdated()->isToday());
    }

    /**
     *@test
     */
    public function an_articles_last_updated_method_returns_the_published_on_date_if_body_updated_on_value_is_null()
    {
        $article = factory(Article::class)->create([
            'body_updated_on' => null,
            'published_on' => Carbon::now()->format('Y-m-d')
        ]);

        $this->assertTrue($article->lastUpdated()->isToday());
    }

    /**
     *@test
     */
    public function the_last_updated_method_will_return_the_created_at_date_if_published_and_body_updated_values_are_null()
    {
        $article = factory(Article::class)->create([
            'body_updated_on' => null,
            'published_on' => null,
            'created_at' => Carbon::parse('-5 days')->format('Y-m-d')
        ]);

        $this->assertTrue($article->lastUpdated()->addDays(5)->isToday());
    }
}