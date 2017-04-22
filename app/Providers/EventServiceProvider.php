<?php

namespace App\Providers;

use App\Events\IssueDeleted;
use App\Listeners\IssueDeletedListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        IssueDeleted::class => [
            IssueDeletedListener::class,
        ],
        'App\Events\IssueCreated' => [
            'App\Listeners\SendIssueNotification'
        ],
        'App\Events\CardDeleted' => [
            'App\Listeners\ClearDeletedCardProduct'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
