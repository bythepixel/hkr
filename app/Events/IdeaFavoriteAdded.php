<?php

namespace App\Events;

use App\Models\IdeaFavorite;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class IdeaFavoriteAdded implements ShouldBroadcast
{
    private $ideaFavorite;

    public function __construct(IdeaFavorite $ideaFavorite)
    {
        $this->ideaFavorite = $ideaFavorite;
    }

    public function broadcastOn()
    {
        return [
            new Channel('hackathon.' . $this->ideaFavorite->hackathon->id),
            new Channel('idea.' . $this->ideaFavorite->idea->id)
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'idea_favorite_id' => $this->ideaFavorite->id,
            'idea_id' => $this->ideaFavorite->idea->id
        ];
    }
}
