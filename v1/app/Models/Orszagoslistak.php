<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orszagoslistak extends Model
{
    protected $table = 'Orszagoslistak';
    protected $primaryKey = 'lista_id';
    public $timestamps = false;

    protected $fillable = [
        'lista_id',
        'nev',
        'tamogatott_part',
    ];

    public function tamogatottPart()
    {
        return $this->belongsTo('App\Models\Partok', 'tamogatott_part');
    }
}
