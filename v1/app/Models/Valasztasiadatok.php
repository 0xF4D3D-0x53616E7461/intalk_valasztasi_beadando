<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valasztasiadatok extends Model
{
    protected $table = 'Valasztasiadatok';
    public $timestamps = false;

    protected $fillable = [
        'ev',
        'orszagoslista',
        'egyeni',
        'valasztokerulet',
        'szavazat',
    ];

    public function orszagosLista()
    {
        return $this->belongsTo('App\Models\Orszagoslistak', 'orszagoslista');
    }

    public function egyeni()
    {
        return $this->belongsTo('App\Models\Egyeni', 'egyeni');
    }

    public function valasztasiKerulet()
    {
        return $this->belongsTo('App\Models\Valasztasikerulet', 'valasztokerulet');
    }
}
