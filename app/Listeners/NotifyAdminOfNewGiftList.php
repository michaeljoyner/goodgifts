<?php

namespace App\Listeners;

use App\Events\GiftListCreated;
use App\Notifications\GiftListCreated as GiftListCreatedNotification;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAdminOfNewGiftList
{

    public function __construct()
    {
        //
    }


    public function handle(GiftListCreated $event)
    {
        User::first()->notify(new GiftListCreatedNotification($event->list));
    }
}
