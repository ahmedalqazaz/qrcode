<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chanel extends Model
{
    
     protected $fillable = [
        'name_chanel',
        'code_chanel'
    ];
    protected $table = 'Chanels';

}
