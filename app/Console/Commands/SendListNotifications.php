<?php

namespace App\Console\Commands;

use App\GiftLists\GiftList;
use App\Notifications\GiftListPublished;
use Illuminate\Console\Command;

class SendListNotifications extends Command
{

    protected $signature = 'giftlists:notify';


    protected $description = 'Sends notifications for due giftlists';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        GiftList::due()->get()->each->sendNotification();
    }
}
