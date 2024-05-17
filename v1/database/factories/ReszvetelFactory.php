<?php

namespace Database\Factories;

use App\Models\Reszvetel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReszvetelFactory extends Factory
{
    protected $model = Reszvetel::class;

    public function definition()
    {
        return [
            'megye_id' => $this->faker->numberBetween(1, 10),
            'reszveteli_arany' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
