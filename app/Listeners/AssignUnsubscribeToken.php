<?php

namespace App\Listeners;

use App\Events\RecommendationRequested;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Ramsey\Uuid\Uuid;

class AssignUnsubscribeToken
{
    public function handle(RecommendationRequested $event)
    {
        $event->request->unsubscribe_token = Uuid::uuid4()->toString();
        $event->request->save();
    }
}
