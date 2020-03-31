<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{

    protected $table = 'invoice_items';

    protected $appends = [
        'total_hrk_price',
        'total_price',
        'discount_price',
        ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function getTotalPriceAttribute()
    {
        return $this->price*(1-$this->discount/100)*$this->amount;
    }

    public function getTotalHrkPriceAttribute()
    {
        $exchange_rate = 1;
        $invoice = $this->invoice;
        if($invoice->currency == 'EUR'){
            $exchange_rate = $invoice->hnb_middle_exchange;
        }
        return $this->total_price*$exchange_rate;
    }

    public function getDiscountPriceAttribute()
    {
        return $this->price*($this->discount/100)*$this->amount;
    }


}
