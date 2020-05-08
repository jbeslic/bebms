<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Associate extends Model
{

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

}
