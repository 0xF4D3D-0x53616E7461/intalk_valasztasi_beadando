<?php

namespace Database\Factories;

use App\Models\Valasztasiadatok;
use Illuminate\Database\Eloquent\Factories\Factory;

class ValasztasiadatokFactory extends Factory
{
    protected $model = Valasztasiadatok::class;

    public function definition()
    {
        return [
            'ev' => $this->faker->year,
            'orszagoslista' => $this->faker->numberBetween(1, 10),
            'egyeni' => $this->faker->numberBetween(1, 10),
            'valasztokerulet' => $this->faker->numberBetween(1, 10),
            'szavazat' => $this->faker->numberBetween(100, 1000),
        ];
    }
}
