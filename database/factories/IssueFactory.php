<?php

namespace Database\Factories;

use App\Models\Issue;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class IssueFactory extends Factory
{
    protected $model = Issue::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->unique()->sentence,
            'description' => $this->faker->paragraph,
            'category_id' => Category::factory(),
            'status' => $this->faker->randomElement(['open', 'closed']),
            'citizen_satisfied' => $this->faker->boolean,
            'sealed_by' => function () {
                return User::factory()->create()->id;
            },
            'to_user_id' => function () {
                return User::factory()->create()->id;
            },
            'visibility' => $this->faker->boolean,
            'file_path' => $this->faker->optional()->filePath(),
        ];
    }
}
