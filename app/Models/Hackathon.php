<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hackathon extends Model
{
    protected $fillable = [];

    protected $hidden = [];

    public function ideas()
    {
        return $this->hasMany(Idea::class);
    }
}
