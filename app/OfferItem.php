<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferItem extends Model
{
    protected $table = 'offer_items';

    public function invoice()
    {
        return $this->belongsTo(Offer::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function getTotalPriceAttribute()
    {
        return $this->price*$this->amount;
    }


}
