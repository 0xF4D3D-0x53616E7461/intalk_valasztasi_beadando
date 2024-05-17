<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Egyeni extends Model
{
    protected $table = 'Egyeni';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'egyeni_id',
        'nev',
        'tamogatott_part',
        'valasztasi_kerulet',
    ];

    public function tamogatottPart()
    {
        return $this->belongsTo('App\Models\Partok', 'tamogatott_part');
    }

    public function valasztasiKerulet()
    {
        return $this->belongsTo('App\Models\Valasztasikerulet', 'valasztasi_kerulet');
    }
}
