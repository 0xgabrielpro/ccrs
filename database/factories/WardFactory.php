<?php

namespace Database\Factories;

use App\Models\Ward;
use Illuminate\Database\Eloquent\Factories\Factory;

class WardFactory extends Factory
{
    protected $model = Ward::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'district_id' => \App\Models\District::factory()->create()->id, 
        ];
    }
}
