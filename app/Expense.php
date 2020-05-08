<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{

    protected $fillable = [
        'project_id',
        'associate_id',
        'expense_date',
        'currency',
        'hnb_middle_exchange',
    ];

    protected $casts = [
        'hnb_middle_exchange' => 'float',
    ];

    protected $appends = [
        'total_hrk_price',
        'total_price',
        'discount_price',
        ];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function associate()
    {
        return $this->belongsTo('App\Associate');
    }

    public function getTotalPriceAttribute()
    {
        return $this->price*(1-$this->discount/100)*$this->amount;
    }

    public function getTotalHrkPriceAttribute()
    {
        $exchange_rate = 1;
        if($this->currency != 'HRK'){
            $exchange_rate = $this->hnb_middle_exchange;
        }
        return $this->total_price*$exchange_rate;
    }

    public function getDiscountPriceAttribute()
    {
        return $this->price*($this->discount/100)*$this->amount;
    }

}
