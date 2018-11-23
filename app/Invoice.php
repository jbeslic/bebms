<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    protected $fillable = [
        'company_id','client_id', 'invoice_date', 'invoice_time', 'payment_deadline', 'remark_id', 'payment_type', 'city', 'is_paid', 'paid', 'invoice_number', 'delivery_date'
    ];

    public function items()
    {
    	return $this->hasMany('App\InvoiceItem');
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
