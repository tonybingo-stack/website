<?php

namespace Database\Factories;

use App\Models\Pro;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProFactory extends Factory
{

    public function definition()
    {
        return [
            'word' => $this->faker->word,
            'sentence' => $this->faker->text,
        ];
    }
}
