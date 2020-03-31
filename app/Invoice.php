<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    protected $fillable = [
        'company_id',
        'client_id',
        'invoice_date',
        'invoice_time',
        'payment_deadline',
        'remark_id',
        'payment_type',
        'city',
        'is_paid',
        'paid',
        'invoice_number',
        'delivery_date',
        'currency',
        'hnb_middle_exchange',
    ];

    protected $casts = [
        'hnb_middle_exchange' => 'float',
    ];

    protected $appends = [
        'total_price',
        'discount_price',
        ];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function setTotalPriceAttribute()
    {
        $this->attributes['total_price'] = $this->items->sum('total_price');
    }

    public function items()
    {
    	return $this->hasMany('App\InvoiceItem');
    }

    public function setDiscountPriceAttribute()
    {
        $this->attributes['discount_price'] = $this->items->sum('discount_price');
    }

}
