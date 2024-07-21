<?php

namespace Database\Factories;

use App\Models\Street;
use Illuminate\Database\Eloquent\Factories\Factory;

class StreetFactory extends Factory
{
    protected $model = Street::class;

    public function definition()
    {
        return [
            'name' => $this->faker->streetName,
            'ward_id' => \App\Models\Ward::factory()->create()->id, 
        ];
    }
}
