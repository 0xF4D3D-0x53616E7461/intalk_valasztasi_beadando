<?php

namespace Database\Factories;

use App\Models\Orszagoslistak;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrszagoslistakFactory extends Factory
{
    protected $model = Orszagoslistak::class;

    public function definition()
    {
        return [
            'nev' => $this->faker->company,
            'tamogatott_part' => $this->faker->numberBetween(1, 10),
        ];
    }
}
