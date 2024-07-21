<?php

namespace Database\Factories;

use App\Models\AnonIssue;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnonIssueFactory extends Factory
{
    protected $model = AnonIssue::class;

    public function definition()
    {
        return [
            'title' => $this->faker->unique()->sentence,
            'description' => $this->faker->paragraph,
            'status' => 'open', // or any default status you want
            'country_id' => \App\Models\Country::factory(),
            'region_id' => \App\Models\Region::factory(),
            'district_id' => \App\Models\District::factory(),
            'ward_id' => \App\Models\Ward::factory(),
            'street_id' => \App\Models\Street::factory(),
            'category_id' => \App\Models\Category::factory(),
            'file_path' => $this->faker->optional()->filePath(),
            'code' => $this->faker->unique()->uuid,
            'citizen_satisfied' => $this->faker->boolean,
            'sealed_by' => $this->faker->optional()->numberBetween(1, 10),
            'to_user_id' => $this->faker->optional()->numberBetween(1, 10),
            'read' => $this->faker->boolean,
            'visibility' => $this->faker->boolean,
        ];
    }
}
