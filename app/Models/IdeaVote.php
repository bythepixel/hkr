<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdeaVote extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function idea()
    {
        return $this->hasOne(Idea::class);
    }
}
