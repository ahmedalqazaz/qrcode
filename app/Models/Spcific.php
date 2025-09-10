<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spcific extends Model
{
    protected $fillable = [
        'code_spcific',
        'name_spcific',
        'code_degree',
        'code_chanal',
        'seat_count'
    ];
    protected $table = 'spcifics';

    public function degree()
    {
        return $this->belongsTo(Degree::class, 'code_degree', 'code_degree');
    }

    public function chanel()
    {
        return $this->belongsTo(Chanel::class, 'code_chanal', 'code_chanal');
    }
}
