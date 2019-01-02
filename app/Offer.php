<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{

    protected $fillable = [
        'company_id','client_id', 'offer_date', 'offer_time', 'payment_deadline', 'remark_id', 'payment_type', 'city', 'is_paid', 'paid'
    ];

    public function items()
    {
    	return $this->hasMany('App\OfferItem');
    }

    public function totalPrice()
    {
        return $this->items()->get()->sum('total_price');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function getTotalPriceAttribute()
    {
        return $this->totalPrice();
    }

}
