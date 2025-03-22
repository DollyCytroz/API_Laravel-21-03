<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criptomoedas extends Model
{
    protected $fillable = [
        'sigla',
        'nome',
        'valor',
    ];
}
