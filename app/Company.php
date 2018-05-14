<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name', 'owner', 'address', 'zip_code', 'city', 'oib', 'iban', 'bank_info', 'activity','logo_path'
    ];
}
