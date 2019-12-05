<?php

namespace App\Events;

use App\Models\IdeaVote;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class IdeaMessageAdded implements ShouldBroadcast
{
    private $ideaMessage;

    public function __construct(IdeaVote $ideaMessage)
    {
        $this->ideaMessage = $ideaMessage;
    }

    public function broadcastOn()
    {
        return new Channel('hackathon.' . $this->ideaMessage->idea->hackathon->id);
    }

    public function broadcastWith(): array
    {
        return [
            'idea_user_id' => $this->ideaMessage->user->id,
            'idea_id' => $this->ideaMessage->idea->id,
            'idea_message_id' => $this->ideaMessage->id,
            'idea_message_content' => $this->ideaMessage->content,
        ];
    }
}
