<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reszvetel extends Model
{
    protected $table = 'Reszvetel';
    public $timestamps = false;

    protected $fillable = [
        'megye_id',
        'reszveteli_arany',
    ];

    public function megye()
    {
        return $this->belongsTo('App\Models\Megye', 'megye_id');
    }
}
