<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdeaFavorite extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }

    public function hackathon()
    {
        return $this->belongsTo(Hackathon::class);
    }
}
