<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Megye extends Model
{
    protected $table = 'Megye';
    protected $primaryKey = 'megye_id';
    public $timestamps = false;

    protected $fillable = [
        'megye_id',
        'nev',
    ];
}
