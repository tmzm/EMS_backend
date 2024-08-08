<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['booths'];

    public function event_participates()
    {
        return $this->hasMany(EventParticipate::class);
    }

    public function booths()
    {
        return $this->hasMany(Booth::class);
    }
}
