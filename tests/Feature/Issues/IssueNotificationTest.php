<?php


namespace Tests\Feature\Issues;


use App\Events\IssueCreated;
use App\Issues\Issue;
use App\Notifications\NotifyOfProductUpdateIssue;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class IssueNotificationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_issue_created_event_is_fired_when_an_issue_is_created()
    {
        Event::fake();
        Model::setEventDispatcher(Event::getFacadeRoot());

        $issue = Issue::createUnavailableProductIssue('A product is unavailable', ['product_id' => 1]);

        Event::assertDispatched(IssueCreated::class, function($event) use ($issue) {
            return $event->issue->id === $issue->id;
        });
    }

    /**
     *@test
     */
    public function a_notification_is_correctly_sent_when_an_issue_is_created()
    {
        Notification::fake();
        $user = factory(User::class)->create();

        $issue = Issue::createUnavailableProductIssue('A product is unavailable', ['product_id' => 1]);

        Notification::assertSentTo($user, NotifyOfProductUpdateIssue::class, function($notification, $channel) use ($issue) {
            return $notification->issue->id === $issue->id;
        });
    }
}