<?php

namespace Database\Factories;

use App\Models\Egyeni;
use Illuminate\Database\Eloquent\Factories\Factory;

class EgyeniFactory extends Factory
{
    protected $model = Egyeni::class;

    public function definition()
    {
        return [
            'egyeni_id' => $this->faker->unique()->numberBetween(1000, 9999),
            'nev' => $this->faker->name,
            'tamogatott_part' => $this->faker->numberBetween(1, 10),
            'valasztasi_kerulet' => $this->faker->numberBetween(1, 10),
        ];
    }
}
