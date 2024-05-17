<?php

namespace Database\Factories;

use App\Models\Partok;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartokFactory extends Factory
{
    protected $model = Partok::class;

    public function definition()
    {
        return [
            'nev' => $this->faker->company,
        ];
    }
}
