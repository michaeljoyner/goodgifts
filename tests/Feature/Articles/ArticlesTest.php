<?php


namespace Tests\Feature;


use App\Articles\Article;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ArticlesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_posted_article_is_correctly_stored()
    {
        $this->disableExceptionHandling();
        $articleData = [
            'title'       => 'The Test Title of all Time',
            'description' => 'The best test description ever',
            'intro'       => 'This is the intro to the test article',
            'target'      => 'A real sucker'
        ];
        $response = $this->asLoggedInUser()->post('/admin/articles', $articleData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('articles', $articleData);
    }

    /**
     * @test
     */
    public function an_article_requires_a_title()
    {
        $articleData = [
            'title'       => '',
            'description' => 'The best test description ever'
        ];
        $response = $this->asLoggedInUser()->post('/admin/articles', $articleData);

        $response->assertSessionHasErrors(['title']);
        $this->assertDatabaseMissing('articles', $articleData);
    }

    /**
     * @test
     */
    public function an_article_requires_a_description()
    {
        $articleData = [
            'title'       => 'testing title',
            'description' => ''
        ];
        $response = $this->asLoggedInUser()->post('/admin/articles', $articleData);

        $response->assertSessionHasErrors(['description']);
        $this->assertDatabaseMissing('articles', $articleData);
    }

    /**
     * @test
     */
    public function an_article_is_correctly_updated()
    {
        $this->disableExceptionHandling();
        $article = factory(Article::class)->create();
        $revisedData = [
            'title'       => 'An updated title',
            'description' => 'A more concise description',
            'target'      => 'A gullible fool'
        ];

        $response = $this->asLoggedInUser()->post('/admin/articles/' . $article->id, $revisedData);

        $this->assertSuccessfulRedirect($response);

        $this->assertDatabaseHas('articles', array_merge(['id' => $article->id], $revisedData));
    }

    /**
     * @test
     */
    public function an_articles_published_status_or_date_cannot_be_updated_via_normal_update_endpoint()
    {
        $article = factory(Article::class)->create(['published' => false, 'published_on' => null]);
        $revisedData = [
            'title'        => 'An updated title',
            'description'  => 'A more concise description',
            'published'    => true,
            'published_on' => Carbon::now()->format('Y-m-d')
        ];

        $response = $this->asLoggedInUser()->post('/admin/articles/' . $article->id, $revisedData);

        $this->assertSuccessfulRedirect($response);

        $this->assertDatabaseHas('articles', [
            'id'           => $article->id,
            'title'        => 'An updated title',
            'description'  => 'A more concise description',
            'published'    => false,
            'published_on' => null
        ]);
    }

    /**
     * @test
     */
    public function the_body_of_an_article_can_be_updated_alone()
    {
        $article = factory(Article::class)->create();

        $response = $this->asLoggedInUser()
            ->patch('/admin/articles/' . $article->id . '/body', ['body' => 'A sexy new body']);

        $response->assertStatus(200);

        $this->assertDatabaseHas('articles', [
            'body'        => 'A sexy new body',
            'id'          => $article->id,
            'title'       => $article->title,
            'slug'        => $article->slug,
            'description' => $article->description,
            'published'   => $article->published
        ]);
    }
}