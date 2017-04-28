<?php


namespace Tests\Feature\Articles;


use App\Articles\Article;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PlainTextTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function an_article_can_be_retrieved_as_plain_text()
    {
        $this->disableExceptionHandling();
        $this->withoutMiddleware();
        $html = '<h1>This is the heading</h1><p>This is the body.</p><img src="test.jpg" alt="foo">';
        $article = factory(Article::class)->create(['body' => $html]);

        $response = $this->get('/articles/' . $article->slug . '/plain-text');

        $response->assertStatus(200);
        $response->assertDontSee('<h1>');
        $response->assertDontSee('</h1>');
        $response->assertDontSee('<p>');
        $response->assertDontSee('</p>');
        $response->assertDontSee('<img');
        $response->assertDontSee('test.jpg');
        $response->assertDontSee('foo');
        $response->assertSee('This is the heading');
        $response->assertSee('This is the body.');
    }
}