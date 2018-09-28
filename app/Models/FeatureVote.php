<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureVote extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
