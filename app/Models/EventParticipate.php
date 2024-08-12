<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventParticipate extends Model
{
    use HasFactory;

    protected $with = ['event_participate_products','event_participate_representatives','invoice', 'user','event'];

    protected $guarded = [];

    public function event_participate_products()
    {
        return $this->hasMany(EventParticipateProduct::class);
    }

    public function event_participate_representatives()
    {
        return $this->hasMany(EventParticipateRepresentative::class);
    }


    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
