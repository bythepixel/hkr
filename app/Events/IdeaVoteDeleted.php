<?php

namespace App\Events;

use App\Models\IdeaVote;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class IdeaVoteDeleted implements ShouldBroadcast
{
    private $ideaVote;

    public function __construct(IdeaVote $ideaVote)
    {
        $this->ideaVote = $ideaVote;
    }

    public function broadcastOn()
    {
        return new Channel('hackathon.' . $this->ideaVote->idea->hackathon->id);
    }

    public function broadcastWith(): array
    {
        return [
            'idea_vote_id' => $this->ideaVote->id,
            'idea_id' => $this->ideaVote->idea->id
        ];
    }
}
