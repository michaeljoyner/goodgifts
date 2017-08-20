<?php


namespace Tests\Feature\GiftLists;


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
    public function a_gift_list_articles_can_be_fetched()
    {
        $this->disableExceptionHandling();
        $list = factory(GiftList::class)->create();
        $articles = factory(Article::class, 5)->create();
        $articles->each(function($article) use ($list) {
            $list->addArticle($article);
        });

        $response = $this->asLoggedInUser()->json('GET', '/admin/giftlists/' . $list->id . '/articles');
        $response->assertStatus(200);

        $fetched_articles = $response->decodeResponseJson();

        $this->assertCount(5, $fetched_articles);
        collect($fetched_articles)->each(function($article) use ($articles) {
            $this->assertContains($article['id'], $articles->pluck('id')->all());
        });
    }

    /**
     *@test
     */
    public function an_article_can_be_attached_to_a_list()
    {
        $this->disableExceptionHandling();
        $list = factory(GiftList::class)->create();
        $article = factory(Article::class)->create();

        $response = $this->asLoggedInUser()
            ->json('POST', '/admin/giftlists/' . $list->id . '/articles/' . $article->id);
        $response->assertStatus(200);

        $this->assertDatabaseHas('article_gift_list', [
            'article_id' => $article->id,
            'gift_list_id' => $list->id
        ]);
    }

    /**
     *@test
     */
    public function an_article_can_be_deleted_from_a_gift_list()
    {
        $this->disableExceptionHandling();
        $list = factory(GiftList::class)->create();
        $article = factory(Article::class)->create();
        $list->addArticle($article);

        $response = $this->asLoggedInUser()
            ->json('DELETE', '/admin/giftlists/' . $list->id . '/articles/' . $article->id);
        $response->assertStatus(200);

        $this->assertDatabaseMissing('article_gift_list', [
            'article_id' => $article->id,
            'gift_list_id' => $list->id
        ]);
    }
}