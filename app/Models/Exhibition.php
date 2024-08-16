<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exhibition extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['booths'];

    public function exhibition_participates()
    {
        return $this->hasMany(ExhibitionParticipate::class);
    }

    public function booths()
    {
        return $this->hasMany(Booth::class);
    }
}
