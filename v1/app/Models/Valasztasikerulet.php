<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valasztasikerulet extends Model
{
    protected $table = 'Valasztasikerulet';
    protected $primaryKey = 'kerulet_id';
    public $timestamps = false;

    protected $fillable = [
        'kerulet_id',
        'nev',
        'megye',
        'varos',
        'tamogatott_part',
    ];

    public function megye()
    {
        return $this->belongsTo('App\Models\Megye', 'megye');
    }

    public function tamogatottPart()
    {
        return $this->belongsTo('App\Models\Partok', 'tamogatott_part');
    }
}
