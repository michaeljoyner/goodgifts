<?php

namespace App\Listeners;

use App\Events\IssueCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use SendPulse\SendpulseApi;

class SendIssueNotification
{

    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  IssueCreated  $event
     * @return void
     */
    public function handle(IssueCreated $event)
    {
        if(env('APP_ENV') !== 'production') {
            return;
        }

        SendPulse::createPushTask([
            'title' => 'An issue has arisen!',
            'body' => 'We have experienced a ' . class_basename($event->issue->issue_type),
            'website_id' => '38463',
            'ttl' => 3000,
            'stretch_time' => 0,
            'link' => 'https://goodgiftsforguys.com/admin/issues/' . $event->issue->id
        ]);
    }
}
