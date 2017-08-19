<?php


namespace Tests\Unit\Recommendations;


use App\Recommendations\PresentedRequest;
use App\Recommendations\Request;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RequestPresenterTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function it_presents_the_sender_name_if_exists_on_request()
    {
        $request = factory(Request::class)->create(['sender' => 'Joe Soap']);

        $presenter = present($request, PresentedRequest::class);

        $this->assertEquals('Joe Soap', $presenter->sender);
    }

    /**
     *@test
     */
    public function it_presents_a_default_sender_name_if_request_has_no_sender_name()
    {
        $request = factory(Request::class)->create(['sender' => '']);

        $presenter = present($request, PresentedRequest::class);

        $this->assertEquals('you beautiful creature', $presenter->sender);
    }

    /**
     *@test
     */
    public function it_presents_a_default_if_the_recipient_name_is_missing()
    {
        $request = factory(Request::class)->create(['recipient' => '']);

        $presenter = present($request, PresentedRequest::class);

        $this->assertEquals('you', $presenter->recipient);
    }

    /**
     *@test
     */
    public function it_presents_a_default_whiteboard_word()
    {
        $request = factory(Request::class)->create(['recipient' => '']);

        $presenter = present($request, PresentedRequest::class);

        $this->assertEquals('something', $presenter->whiteboard_word);
    }

    /**
     *@test
     */
    public function the_whiteboard_word_is_just_the_recipients_name_in_quotes_if_exists()
    {
        $request = factory(Request::class)->create(['recipient' => 'Bob Hope']);

        $presenter = present($request, PresentedRequest::class);

        $this->assertEquals('"Bob Hope"', $presenter->whiteboard_word);
    }

    /**
     * @test
     */
    public function it_presents_the_formatted_date()
    {
        $date = Carbon::parse('+5 months');
        $request = factory(Request::class)->create(['birthday' => $date->format('m-d')]);

        $presenter = present($request->fresh(), PresentedRequest::class);

        $this->assertEquals('on ' . $date->subDays(30)->toFormattedDateString(), $presenter->mail_date);
    }

    /**
     *@test
     */
    public function should_the_mail_date_be_less_than_30_days_a_reasonable_substitute_is_given()
    {
        $date = Carbon::parse('+5 days');
        $request = factory(Request::class)->create(['birthday' => $date->format('m-d')]);

        $presenter = present($request->fresh(), PresentedRequest::class);

        $this->assertEquals('soon', $presenter->mail_date);
    }
}