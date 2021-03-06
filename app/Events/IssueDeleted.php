<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class IssueDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $issue;

    /**
     * Create a new event instance.
     *
     * @param $issue
     */
    public function __construct($issue)
    {
        $this->issue = $issue;
    }
}
