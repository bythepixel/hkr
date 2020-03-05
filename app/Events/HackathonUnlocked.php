<?php

namespace App\Events;

use App\Models\Hackathon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class HackathonUnlocked implements ShouldBroadcast
{
    private $hackathon;

    public function __construct(Hackathon $hackathon)
    {
        $this->hackathon = $hackathon;
    }

    public function broadcastOn()
    {
        return new Channel('hackathon.' . $this->hackathon->id);
    }
}
