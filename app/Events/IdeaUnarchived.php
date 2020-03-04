<?php

namespace App\Events;

use App\Models\Idea;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class IdeaUnarchived implements ShouldBroadcast
{
    private $idea;

    public function __construct(Idea $idea)
    {
        $this->idea = $idea;
    }

    public function broadcastOn()
    {
        return new Channel('hackathon.' . $this->idea->hackathon->id);
    }
}
