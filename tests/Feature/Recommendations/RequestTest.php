<?php


namespace Tests\Feature\Recommendations;


use App\Recommendations\Request;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RequestTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_valid_recommendation_request_can_be_submitted()
    {
        $this->disableExceptionHandling();

        $response = $this->post('/recommendations/request', [
            'email'     => 'joe@example.com',
            'sender'    => 'Joe Soap',
            'recipient' => 'Junior Soap',
            'birthday'  => '05-05',
            'interests' => 'running,jumping,masturbating'
        ]);

        $response->assertStatus(200);

        $this->assertCount(1, Request::all());
        $this->assertDatabaseHas('requests', [
            'email'     => 'joe@example.com',
            'sender'    => 'Joe Soap',
            'recipient' => 'Junior Soap'
        ]);
    }

    /**
     * @test
     */
    public function a_request_requires_an_email()
    {
        $response = $this->json('POST', '/recommendations/request', [
            'sender'    => 'Joe Soap',
            'recipient' => 'Junior Soap',
            'birthday'  => '05-05',
            'interests' => 'running,jumping,masturbating'
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['email']);
        $this->assertCount(0, Request::all());
    }

    /**
     * @test
     */
    public function a_request_requires_a_birthday()
    {
        $response = $this->json('POST', '/recommendations/request', [
            'email'     => 'joe@example.com',
            'sender'    => 'Joe Soap',
            'recipient' => 'Junior Soap',
            'interests' => 'running,jumping,masturbating'
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['birthday']);
        $this->assertCount(0, Request::all());
    }

    /**
     *@test
     */
    public function a_request_birthday_must_be_a_valid_month_and_day()
    {
        $response = $this->json('POST', '/recommendations/request', [
            'email'     => 'joe@example.com',
            'sender'    => 'Joe Soap',
            'birthday'  => '34-99', //does not match /^(0[1-9]|1[012])-(0[1-9]|[12][1-9]|3[01])$/
            'recipient' => 'Junior Soap',
            'interests' => 'running,jumping,masturbating'
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['birthday']);
        $this->assertCount(0, Request::all());
    }

    /**
     *@test
     */
    public function a_request_requires_some_interests()
    {
        $response = $this->json('POST', '/recommendations/request', [
            'email'     => 'joe@example.com',
            'sender'    => 'Joe Soap',
            'birthday'  => '01-01', //does not match /^(0[1-9]|1[012])-(0[1-9]|[12][1-9]|3[01])$/
            'recipient' => 'Junior Soap'
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['interests']);
        $this->assertCount(0, Request::all());
    }
}