<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'role' => $this->faker->randomElement(['citizen', 'leader', 'admin']),
            'country_id' => function () {
                return \App\Models\Country::factory()->create()->id;
            },
            'region_id' => function () {
                return \App\Models\Region::factory()->create()->id;
            },
            'district_id' => function () {
                return \App\Models\District::factory()->create()->id;
            },
            'ward_id' => function () {
                return \App\Models\Ward::factory()->create()->id;
            },
            'street_id' => function () {
                return \App\Models\Street::factory()->create()->id;
            },
            'leader_id' => function () {
                return \App\Models\Leader::factory()->create()->id;
            },
            'category_id' => function () {
                return \App\Models\Category::factory()->create()->id;
            },
        ];
    }
}
