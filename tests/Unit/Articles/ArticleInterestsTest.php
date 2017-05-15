<?php


namespace Tests\Unit\Articles;


use App\Articles\Article;
use App\Interests\Interest;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ArticleInterestsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_set_of_interests_can_be_set_on_the_article()
    {
        $article = factory(Article::class)->create();
        $interests = collect(['running', 'jumping', 'testing']);

        $article->setInterests($interests);

        $this->assertCount(3, $article->interests);

        $interests->each(function($interest) use ($article) {
            $this->assertTrue($article->hasInterest($interest));
        });
    }

    /**
     *@test
     */
    public function an_article_knows_if_it_has_a_given_interest()
    {
        $article = factory(Article::class)->create();
        $interest = factory(Interest::class)->create(['interest' => 'testing']);

        $article->interests()->attach($interest->id);

        $this->assertTrue($article->hasInterest('testing'));
        $this->assertFalse($article->hasInterest('non-testing'));
    }
}