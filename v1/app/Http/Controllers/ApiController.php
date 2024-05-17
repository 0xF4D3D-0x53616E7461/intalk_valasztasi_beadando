<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partok;
use App\Models\Megye;
use App\Models\Valasztasiadatok;

class ApiController extends Controller
{
    public function getIndulo($nev)
    {
        $indulo = Partok::where('nev', $nev)->firstOrFail();

        $szavazatok = Valasztasiadatok::where('egyeni', $indulo->egyeni_id)->sum('szavazat');

        $nyer = $szavazatok > 0;

        return response()->json([
            'pártja' => $indulo->tamogatottPart->nev,
            'megye' => $indulo->valasztasiKerulet->megye->nev,
            'országos lista' => $indulo->orszagosLista->nev,
            'szavazatot kapott' => $szavazatok,
            'Nyer?' => $nyer,
            'év' => Valasztasiadatok::where('egyeni', $indulo->egyeni_id)->pluck('ev')->last(),
        ]);
    }

    public function getMegye($nev)
    {
        $megye = Megye::where('nev', $nev)->firstOrFail();

        $nyer = $megye->reszvetel->reszveteli_arany > 66;

        return response()->json([
            'indulo neve' => $megye->valasztasikerulet->egyeni->nev,
            'Terület' => $megye->nev,
            'párt' => $megye->valasztasikerulet->egyeni->tamogatottPart->nev,
            'szavazatot kapott' => $megye->reszvetel->reszveteli_arany,
            '2/3 felett nyert?' => $nyer,
            'Nyert?' => $megye->valasztasikerulet->kerulet_id === 1, // Példa feltételezve, hogy az első kerület győzött
        ]);
    }

    public function getPart($nev)
    {
        $part = Partok::where('nev', $nev)->firstOrFail();

        $nyer = $part->reszvetel->reszveteli_arany > 50;

        return response()->json([
            'indulo neve' => $part->valasztasikerulet->egyeni->nev,
            'terület' => $part->valasztasikerulet->varos,
            'szavazatot kapott' => $part->reszvetel->reszveteli_arany,
            'Országos lista' => $part->orszagoslista->nev,
            'utoljára nyert' => $nyer ? 'Igen' : 'Nem',
            'Nyerési esély %' => $nyer ? '100%' : '50%', // Példa, a valós adatoktól függően
        ]);
    }
}