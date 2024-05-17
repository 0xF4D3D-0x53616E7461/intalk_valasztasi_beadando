<?php

namespace Database\Factories;

use App\Models\Megye;
use Illuminate\Database\Eloquent\Factories\Factory;

class MegyeFactory extends Factory
{
    protected $model = Megye::class;

    public function definition()
    {
        return [
            'nev' => $this->faker->city,
        ];
    }
}
