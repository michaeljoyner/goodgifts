<?php


namespace Tests\Feature\Interests;


use App\Articles\Article;
use App\Interests\Interest;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class InterestsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function interests_can_be_added_to_an_article()
    {
        $this->disableExceptionHandling();
        $article = factory(Article::class)->create();
        $interests = 'running, jumping, testing';

        $response = $this->asLoggedInUser()
            ->put('/admin/articles/' . $article->id . '/interests', ['interests' => $interests]);

        $response->assertStatus(200);
        $responseInterests = $response->decodeResponseJson();

        $this->assertCount(3, $responseInterests);
        $this->assertCount(3, Interest::all());
    }

    /**
     *@test
     */
    public function an_articles_interests_can_be_retrieved()
    {
        $article = factory(Article::class)->create();
        $article->setInterests(collect(['running', 'jumping', 'testing']));

        $response = $this->asLoggedInUser()->get('/admin/articles/' . $article->id . '/interests');
        $response->assertStatus(200);

        $this->assertEquals($response->decodeResponseJson(), ['running', 'jumping', 'testing']);
    }

    /**
     *@test
     */
    public function all_interests_can_be_retrieved_as_a_list()
    {
        collect(range(1,5))->each(function($num) {
            factory(Interest::class)->create(['interest' => "TEST_INTEREST_$num"]);
        });
        $expected = [
            ['id' => 1, 'name' =>'TEST_INTEREST_1'],
            ['id' => 2, 'name' =>'TEST_INTEREST_2'],
            ['id' => 3, 'name' =>'TEST_INTEREST_3'],
            ['id' => 4, 'name' =>'TEST_INTEREST_4'],
            ['id' => 5, 'name' =>'TEST_INTEREST_5']
        ];

        $response = $this->asLoggedInUser()->get('/admin/interests');
        $response->assertStatus(200);

        $this->assertCount(5, $response->decodeResponseJson());
        $this->assertEquals($expected, $response->decodeResponseJson());
    }
}