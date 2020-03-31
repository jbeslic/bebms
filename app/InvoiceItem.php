<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{

    protected $table = 'invoice_items';

    protected $appends = [
        'total_price',
        'discount_price',
        ];

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
        $exchange_rate = 1;
        $invoice = $this->invoice;
        if($invoice->currency == 'EUR'){
            $exchange_rate = $invoice->hnb_middle_exchange;
        }
        return $this->price*(1-$this->discount/100)*$this->amount*$exchange_rate;
    }

    public function getDiscountPriceAttribute()
    {
        return $this->price - $this->total_price;
    }


}
