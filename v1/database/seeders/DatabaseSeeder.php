<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partok;
use App\Models\Megye;
use App\Models\Valasztasikerulet;
use App\Models\Egyeni;
use App\Models\Orszagoslistak;
use App\Models\Valasztasiadatok;
use App\Models\Reszvetel;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Partok létrehozása
        Partok::factory()->count(10)->create();

        // Megye létrehozása
        Megye::factory()->count(10)->create();

        // Valasztasikerulet létrehozása
        Valasztasikerulet::factory()->count(10)->create();

        // Egyeni létrehozása
        Egyeni::factory()->count(10)->create();

        // Orszagoslistak létrehozása
        Orszagoslistak::factory()->count(10)->create();

        // Valasztasiadatok létrehozása
        Valasztasiadatok::factory()->count(10)->create();

        // Reszvetel létrehozása
        Reszvetel::factory()->count(10)->create();
    }
}
