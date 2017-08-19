<?php


namespace Tests\Feature\GiftLists;


use App\Console\Commands\SendListNotifications;
use App\Notifications\GiftListPublished;
use App\Recommendations\Request;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class GiftListNotificationsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function due_gift_lists_are_correctly_notified()
    {
        $this->disableExceptionHandling();
        Notification::fake();

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
}