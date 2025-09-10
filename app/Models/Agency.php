<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
     protected $fillable = [
        'age_code',
        'age_name'
    ];
    protected $table = 'agencies';
}
