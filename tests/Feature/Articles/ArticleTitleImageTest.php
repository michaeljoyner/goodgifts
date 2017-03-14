<?php


namespace Tests\Feature\Articles;


use App\Articles\Article;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ArticleTitleImageTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function the_title_image_is_correctly_updated_on_the_article()
    {
        $article = factory(Article::class)->create();

        $response = $this->asLoggedInUser()->json('POST', '/admin/articles/' . $article->id . '/titleimage', [
            'image' => UploadedFile::fake()->image('test-title.jpg')
        ]);

        $response->assertStatus(200);

        $this->assertContains('test-title.jpg', $article->fresh()->titleImage());
    }
}