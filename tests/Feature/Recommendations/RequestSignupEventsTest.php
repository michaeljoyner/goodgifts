<?php


namespace Tests\Feature\Recommendations;


use App\Mail\SignupWelcomeMail;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RequestSignupEventsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function when_a_signup_request_is_created_an_email_is_sent()
    {
        Mail::fake();
        Notification::fake();

        $this->disableExceptionHandling();

        $this->post('/recommendations/request', [
            'email'     => 'joe@example.com',
            'sender'    => 'Joe Soap',
            'recipient' => 'Junior Soap',
            'birthday_day'  => '05',
            'birthday_month'  => '05',
            'interests' => 'running,jumping,masturbating',
            'age_group' => 'mature'
        ])->assertStatus(302);

        Mail::assertSent(SignupWelcomeMail::class, function($mail) {
           return $mail->request->sender === 'Joe Soap';
        });
    }
}