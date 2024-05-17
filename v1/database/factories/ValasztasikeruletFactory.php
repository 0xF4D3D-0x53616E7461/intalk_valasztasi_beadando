<?php

namespace Database\Factories;

use App\Models\Valasztasikerulet;
use Illuminate\Database\Eloquent\Factories\Factory;

class ValasztasikeruletFactory extends Factory
{
    protected $model = Valasztasikerulet::class;

    public function definition()
    {
        return [
            'nev' => $this->faker->word,
            'megye' => $this->faker->numberBetween(1, 10),
            'varos' => $this->faker->city,
            'tamogatott_part' => $this->faker->numberBetween(1, 10),
        ];
    }
}
