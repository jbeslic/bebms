<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    //

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    protected $fillable = [
        'company_id','client_id', 'content'
    ];
}
