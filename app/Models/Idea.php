<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hackathon()
    {
        return $this->belongsTo(Hackathon::class);
    }

    public function messages()
    {
        return $this->hasMany(IdeaMessage::class);
    }

    public function votes()
    {
        return $this->hasMany(IdeaVote::class);
    }
}
