<?php


namespace Tests\Unit\GiftLists;


use App\Articles\Article;
use App\GiftLists\GiftList;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class GiftListArticlesTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        Notification::fake();
    }

    /**
     *@test
     */
    public function an_article_may_be_added_to_a_gift_list()
    {
        $list = factory(GiftList::class)->create();
        $article = factory(Article::class)->create();

        $list->addArticle($article);

        $this->assertCount(1, $list->fresh()->articles);
        $this->assertEquals($article->id, $list->fresh()->articles->first()->id);
    }

    /**
     *@test
     */
    public function an_article_may_be_removed_from_a_gift_list()
    {
        $list = factory(GiftList::class)->create();
        $article = factory(Article::class)->create();
        $list->addArticle($article);
        $list = $list->fresh();

        $list->removeArticle($article);

        $this->assertCount(0, $list->fresh()->articles);
    }
}