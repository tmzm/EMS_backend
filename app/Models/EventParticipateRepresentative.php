<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventParticipateRepresentative extends Model
{
    use HasFactory;

    protected $with = ['representative'];

    protected $guarded = [];

    public function representative()
    {
        return $this->belongsTo(Representative::class);
    }
}
