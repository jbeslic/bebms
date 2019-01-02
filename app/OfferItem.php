<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferItem extends Model
{
    public function invoice()
    {
        return $this->belongsTo('App\Offer');
    }
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    public function getTotalPriceAttribute()
    {
        return $this->price*$this->amount;
    }


}
