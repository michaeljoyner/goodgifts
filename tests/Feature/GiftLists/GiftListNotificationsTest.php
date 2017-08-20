<?php


namespace Tests\Feature\GiftLists;


use App\Console\Commands\SendListNotifications;
use App\Notifications\GiftListCreated;
use App\Notifications\GiftListPublished;
use App\Recommendations\Request;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class GiftListNotificationsTest extends TestCase
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
    public function due_gift_lists_are_correctly_notified()
    {
        $this->disableExceptionHandling();

        $request = factory(Request::class)->create([
            'birthday' => Carbon::parse('+19 days'),
            'email'    => 'test@example.com'
        ]);

        $list = $request->createGiftList();
        $list->update(['approved' => true, 'sent' => false]);

        $mailman = $this->app->make(SendListNotifications::class);
        $mailman->handle();

        Notification::assertSentTo($list, GiftListPublished::class, function($notification, $channels) use ($list) {
            return $notification->list->id === $list->id;
        });

        $this->assertTrue($list->fresh()->sent);
    }

    /**
     *@test
     */
    public function admin_users_are_notified_of_a_new_gift_list()
    {
        $this->asLoggedInUser();
        $this->disableExceptionHandling();

        $request = factory(Request::class)->create([
            'birthday' => Carbon::parse('+3 months'),
            'sender' => 'TEST SENDER',
            'budget' => 'high',
            'email'    => 'test@example.com'
        ]);

        $list = $request->createGiftList();

        User::all()->each(function($user) use ($list) {

            Notification::assertSentTo($user, GiftListCreated::class, function($notification, $channels) use ($list) {
                return $notification->list->id === $list->id;
            });
        });

    }
}