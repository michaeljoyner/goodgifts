<?php


namespace Tests\Feature\Recommendations;


use App\Recommendations\Request;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RequestTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        Notification::fake();
    }

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
            'birthday_day'  => Carbon::now()->addMonths(1)->format('d'),
            'birthday_month' => Carbon::now()->addMonths(1)->format('m'),
            'interests' => 'running,jumping,masturbating',
            'age_group' => 'mature'
        ]);

        $response->assertStatus(302);
        $response->assertSessionMissing('errors');

        $this->assertCount(1, Request::all());
        $this->assertDatabaseHas('requests', [
            'email'     => 'joe@example.com',
            'sender'    => 'Joe Soap',
            'recipient' => 'Junior Soap',
            'age_group' => 'mature',
            'birthday' => Carbon::now()->addMonths(1)->format('Y-m-d') . ' 00:00:00'
        ]);

    }

    /**
     *@test
     */
    public function a_successfully_submitted_request_results_in_a_new_gift_list_being_created()
    {
        $this->disableExceptionHandling();

        $response = $this->post('/recommendations/request', [
            'email'     => 'joe@example.com',
            'sender'    => 'Joe Soap',
            'recipient' => 'Junior Soap',
            'birthday_day'  => Carbon::now()->addMonths(1)->format('d'),
            'birthday_month' => Carbon::now()->addMonths(1)->format('m'),
            'interests' => 'running,jumping,masturbating',
            'age_group' => 'mature'
        ]);

        $response->assertStatus(302);
        $response->assertSessionMissing('errors');

        $this->assertCount(1, Request::all());
        $request = Request::first();

        $this->assertDatabaseHas('gift_lists', [
            'request_id'     => $request->id,
            'writeup'    => null,
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
        $this->assertArrayHasKey('email', $response->decodeResponseJson()['errors']);
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
        $this->assertArrayHasKey('birthday_month', $response->decodeResponseJson()['errors']);
        $this->assertArrayHasKey('birthday_day', $response->decodeResponseJson()['errors']);
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
        $this->assertArrayHasKey('birthday_month', $response->decodeResponseJson()['errors']);
        $this->assertArrayHasKey('birthday_day', $response->decodeResponseJson()['errors']);
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
        $this->assertArrayHasKey('interests', $response->decodeResponseJson()['errors']);
        $this->assertCount(0, Request::all());
    }
}