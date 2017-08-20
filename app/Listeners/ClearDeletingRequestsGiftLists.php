<?php

namespace App\Listeners;

use App\Events\RecommendationRequestDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClearDeletingRequestsGiftLists
{

    public function handle(RecommendationRequestDeleted $event)
    {
        $event->request->giftLists->each->delete();
    }
}
