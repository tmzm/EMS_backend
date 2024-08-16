<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExhibitionParticipate extends Model
{
    use HasFactory;

    protected $with = ['exhibition_participate_products','exhibition_participate_representatives','invoice', 'user','exhibition'];

    protected $guarded = [];

    public function exhibition_participate_products()
    {
        return $this->hasMany(ExhibitionParticipateProduct::class);
    }

    public function exhibition_participate_representatives()
    {
        return $this->hasMany(ExhibitionParticipateRepresentative::class);
    }


    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class);
    }
}
