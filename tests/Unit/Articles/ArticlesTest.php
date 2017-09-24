<?php


namespace Tests\Unit\Articles;


use App\Articles\Article;
use App\Products\Product;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Tests\MakesArticlesWithProducts;
use Tests\TestCase;

class ArticlesTest extends TestCase
{
    use DatabaseMigrations, MakesArticlesWithProducts;
    /**
     *@test
     */
    public function an_article_has_a_slug()
    {
        $article = factory(Article::class)->create(['title' => 'test example title']);

        $this->assertEquals('test-example-title', $article->slug);
    }

    /**
     *@test
     */
    public function an_article_is_not_published_by_default()
    {
        $article = factory(Article::class)->create();

        $this->assertFalse($article->isPublished());
    }

    /**
     *@test
     */
    public function an_article_can_be_published()
    {
        $article = factory(Article::class)->create(['published' => false, 'published_on' => null]);

        $article->publish();

        $this->assertTrue($article->fresh()->isPublished());
    }

    /**
     *@test
     */
    public function a_date_may_be_passed_to_the_publish_method_to_set_published_on_date()
    {
        $article = factory(Article::class)->create(['published' => false, 'published_on' => null]);

        $article->publish(Carbon::parse('+7 days')->format('Y-m-d'));

        $this->assertEquals(Carbon::parse('+7 days')->format('Y-m-d'), $article->fresh()->published_on->format('Y-m-d'));

    }

    /**
     *@test
     */
    public function an_article_can_be_retracted()
    {
        $article = factory(Article::class)->create(['published' => true, 'published_on' => Carbon::parse('-10 days')]);

        $article->retract();

        $this->assertFalse($article->fresh()->isPublished(), 'article should no longer be published');
    }

    /**
     *@test
     */
    public function an_articles_published_at_date_is_still_updated_when_retracted()
    {
        $article = factory(Article::class)->create(['published' => true, 'published_on' => Carbon::parse('-10 days')]);

        $article->retract(Carbon::now()->format('Y-m-d'));

        $this->assertFalse($article->fresh()->isPublished());
        $this->assertTrue($article->fresh()->published_on->isToday());
    }

    /**
     *@test
     */
    public function an_articles_slug_will_update_only_if_it_has_not_been_published()
    {
        $article = factory(Article::class)->create(['title' => 'test example title']);

        $this->assertEquals('test-example-title', $article->slug);

        $article->title = 'a new title';
        $article->save();

        $this->assertEquals('a-new-title', $article->fresh()->slug);

        $article->publish();

        $article = $article->fresh();

        $article->title = 'should not change slug';
        $article->save();

        $this->assertEquals('a-new-title', $article->fresh()->slug);
        $this->assertEquals('should not change slug', $article->fresh()->title);
    }

    /**
     *@test
     */
    public function an_image_can_be_added_to_an_article()
    {
        $article = factory(Article::class)->create();

        $article->addImage(UploadedFile::fake()->image('testimage.png'));

        $this->assertCount(1, $article->getMedia());

        $article->clearMediaCollection();
    }

    /**
     *@test
     */
    public function a_title_image_can_be_added_to_an_article()
    {
        $article = factory(Article::class)->create();

        $image = $article->setTitleImage(UploadedFile::fake()->image('title-test.jpg'));
        $this->assertTrue($image->fresh()->getCustomProperty('is_title'));

        $this->assertEquals($image->getUrl('web'), $article->fresh()->titleImage('web'));
    }

    /**
     *@test
     */
    public function a_pre_existing_title_image_is_deleted_when_a_title_image_is_set()
    {
        $article = factory(Article::class)->create();
        $firstTitleImg = $article->setTitleImage(UploadedFile::fake()->image('first.png'));
        $firstFilePath = $firstTitleImg->getPath();
        $this->assertTrue(file_exists($firstFilePath));

        $second = $article->fresh()->setTitleImage(UploadedFile::fake()->image('second.png'));


        $this->assertEquals($second->getUrl(), $article->fresh()->titleImage());

        $this->assertDatabaseMissing('media', ['id' => $firstTitleImg->id]);
        $this->assertFalse(file_exists($firstFilePath));
    }

    /**
     *@test
     */
    public function an_article_has_a_default_title_image()
    {
        $article = factory(Article::class)->create();

        $this->assertEquals(Article::DEFAULT_TITLE_IMG, $article->titleImage('web'));
    }

    /**
     * @test
     */
    public function articles_may_be_scoped_to_published_only()
    {
        factory(Article::class, 3)->create(['published' => false, 'published_on' => null]);
        factory(Article::class, 3)->create(['published' => true, 'published_on' => Carbon::now()]);

        $results = Article::published()->get();

        $this->assertCount(3, $results);
        $results->each(function($article) {
            $this->assertTrue($article->isPublished());
        });
    }

    /**
     *@test
     */
    public function the_published_scope_also_filters_out_articles_published_but_only_for_a_future_date()
    {
        factory(Article::class, 3)->create(['published' => false, 'published_on' => null]);
        factory(Article::class, 3)->create(['published' => true, 'published_on' => Carbon::parse('+5 days')]);

        $results = Article::published()->get();

        $this->assertCount(0, $results);
    }

    /**
     *@test
     */
    public function an_article_can_present_itself_as_a_preview_array()
    {
        $article = factory(Article::class)->create([
            'title' => 'TEST TITLE',
            'intro' => 'TEST INTRO',
            'target' => 'TEST TARGET'
        ]);

        $expected = [
            'title' => 'TEST TITLE',
            'image' => Article::DEFAULT_TITLE_IMG,
            'article_link' => '/articles/test-title',
            'intro' => 'TEST INTRO',
            'target' => 'TEST TARGET',
            'is_real' => true
        ];

        $this->assertEquals($expected, $article->toPreviewArray());
    }

    /**
     *@test
     */
    public function an_article_can_replace_an_article_in_its_body()
    {
        $productA = factory(Product::class)->create([
            'itemid'      => 'AAAAAAAAAA',
            'title'       => 'A Product',
            'description' => 'A Description',
            'link'        => 'A-link',
            'image'       => 'A-image',
            'price'       => '$AAA'
        ]);
        $productB = factory(Product::class)->create([
            'itemid'      => 'BBBBBBBBBB',
            'title'       => 'B Product',
            'description' => 'B Description',
            'link'        => 'B-link',
            'image'       => 'B-image',
            'price'       => '$BBB',
            'available'   => true
        ]);

        $article = $this->makeArticleWithProducts([$productA->toArray()]);
        $article->attachProducts(collect($productA));

        $article->replaceProductInBody($productA->toArray(), $productB);

        $this->assertContains('B Product', $article->fresh()->body);
        $this->assertContains('B-link', $article->fresh()->body);
        $this->assertContains('B-image', $article->fresh()->body);
    }

    /**
     *@test
     */
    public function replacing_a_product_also_replaces_its_text_links()
    {
        $linkA = 'https://www.amazon.com/JBL-Splash-Portable-Bluetooth-Speaker/dp/B0145EVLCC?psc=1&SubscriptionId=AKIAIYHMBBZCAVFTSEKQ&tag=goodgifts0c-20&linkCode=xm2&camp=2025&creative=165953&creativeASIN=B0145EVLMM';
        $linkB = 'https://www.amazon.com/JBL-Splash-Portable-Bluetooth-Speaker/dp/B0145EVLMM?psc=1&SubscriptionId=AKIAIYHMBBZCAVFTSEKQ&tag=goodgifts0c-20&linkCode=xm2&camp=2025&creative=165953&creativeASIN=B0145EVLMM';
        $productA = factory(Product::class)->create([
            'itemid'      => 'AAAAAAAAAA',
            'title'       => 'A Product',
            'description' => 'A Description',
            'link'        => $linkA,
            'image'       => 'A-image',
            'price'       => '$AAA'
        ]);
        $productB = factory(Product::class)->create([
            'itemid'      => 'BBBBBBBBBB',
            'title'       => 'B Product',
            'description' => 'B Description',
            'link'        => $linkB,
            'image'       => 'B-image',
            'price'       => '$BBB',
            'available'   => true
        ]);

        $article = $this->makeArticleWithProducts([$productA->toArray()]);
        $article->attachProducts(collect($productA));

        $article->replaceProductInBody($productA->toArray(), $productB);

        $this->assertNotContains($linkA, $article->fresh()->body);
        $this->assertContains($linkB, $article->fresh()->body);
    }
}