<?php


namespace Tests\Feature\Articles;



use App\Articles\Article;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ArticleImagesTest extends TestCase
{
    use DatabaseMigrations;
    /**
     *@test
     */
    public function an_image_may_be_uploaded_to_an_article()
    {
        $this->disableExceptionHandling();
        $article = factory(Article::class)->create();

        $response = $this->asLoggedInUser()->json('POST', '/admin/articles/' . $article->id . '/images', [
            'image' => UploadedFile::fake()->image('test-upload.jpg', 100, 100)->size(100)
        ]);

        $response->assertStatus(200);
        $this->assertCount(1, $article->fresh()->getMedia());
        $imageUrl = $article->fresh()->getMedia()->first()->getUrl('web');

        $response->assertJson(['location' => $imageUrl]);

        $article->clearMediaCollection();
    }
}