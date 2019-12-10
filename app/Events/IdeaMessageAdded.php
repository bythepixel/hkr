<?php

namespace App\Events;

use App\Models\IdeaMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class IdeaMessageAdded implements ShouldBroadcast
{
    private $ideaMessage;

    public function __construct(IdeaMessage $ideaMessage)
    {
        $this->ideaMessage = $ideaMessage;
    }

    public function broadcastOn()
    {
        return [
            new Channel('idea.' . $this->ideaMessage->idea->id),
            new Channel('hackathon.' . $this->ideaMessage->idea->hackathon->id)
        ];
    }
}
