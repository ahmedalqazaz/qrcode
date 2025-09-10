<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
     protected $fillable = [
        'name_degree',
        'code_degree'
    ];
    protected $table = 'degrees';
}
