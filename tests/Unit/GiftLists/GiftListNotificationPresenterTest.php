<?php


namespace Tests\Unit\GiftLists;


use App\GiftLists\GiftList;
use App\GiftLists\GiftListNotificationPresenter;
use App\Recommendations\Request;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class GiftListNotificationPresenterTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        Notification::fake();
    }

    /**
     *@test
     */
    public function it_presents_a_correct_subject_if_both_sender_and_recipient_names_are_known()
    {
        $list = $this->presentListFor('Carol', 'Mike');

        $this->assertEquals('Hey Carol, your gift list for Mike is ready!', $list->subject_line);
    }

    /**
     * @test
     */
    public function it_presents_a_valid_subject_line_if_the_sender_name_is_missing()
    {
        $list = $this->presentListFor(null, 'Mike');

        $this->assertEquals('Hey there, your gift list for Mike is ready!', $list->subject_line);
    }

    /**
     *@test
     */
    public function it_presents_a_good_subject_line_if_the_recipient_is_falsey()
    {
        $list = $this->presentListFor('Carol', '');

        $this->assertEquals('Hey Carol, that gift list you asked for is ready!', $list->subject_line);
    }

    /**
     *@test
     */
    public function it_presents_a_subject_line_without_any_given_names()
    {
        $list = $this->presentListFor('', null);

        $this->assertEquals('Hey there, that gift list you asked for is ready!', $list->subject_line);
    }

    /**
     *@test
     */
    public function it_uses_the_lists_writeup_as_an_intro()
    {
        $list = $this->presentListFor('Sender', 'Recipient', 'Hey there you silly thing');

        $this->assertEquals('Hey there you silly thing', $list->intro);
    }

    /**
     *@test
     */
    public function it_uses_an_appropriate_intro_if_writeup_is_missing_and_recipient_exists()
    {
        $list = $this->presentListFor('Sender', 'Recipient', null);

        $expected = 'You didn\'t forget about Recipient did you? Of course you didn\'t. And neither did we.';

        $this->assertEquals($expected, $list->intro);
    }

    /**
     *@test
     */
    public function it_uses_a_decent_intro_if_both_writeup_and_recipient_are_missing()
    {
        $list = $this->presentListFor('Sender', null, null);

        $expected = 'You didn\'t forget about his big day did you? Of course you didn\'t. And neither did we.';

        $this->assertEquals($expected, $list->intro);
    }

    protected function presentListFor($sender, $recipient, $writeup = 'TEST WRITEUP')
    {
        $request = factory(Request::class)->create(['recipient' => $recipient, 'sender' => $sender]);
        $list = factory(GiftList::class)->create(['request_id' => $request->id, 'writeup' => $writeup]);

        return $list->present(GiftListNotificationPresenter::class);
    }


}