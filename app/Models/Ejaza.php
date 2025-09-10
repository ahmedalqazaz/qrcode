<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ejaza extends Model
{
      protected $fillable = [
        'name_ejaza',
        'code_ejaza'
    ];
    protected $table = 'ejazas';
}
