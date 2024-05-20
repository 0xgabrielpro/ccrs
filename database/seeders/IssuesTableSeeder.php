<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Issue;
use App\Models\User;
use Faker\Factory as Faker;

class IssuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = User::all();

        if ($users->count() === 0) {
            $this->command->info('Please create some users first!');
            return;
        }

        foreach ($users as $user) {
            for ($i = 0; $i < 4; $i++) {
                Issue::create([
                    'user_id' => $user->id,
                    'title' => $faker->sentence,
                    'description' => $faker->paragraph,
                    'category_id' => null, // No categories table, so we set it to null
                    'location' => $faker->address,
                    'visibility' => $faker->boolean,
                    'status' => $faker->randomElement(['open', 'inprogress', 'resolved', 'closed']),
                    'citizen_satisfied' => $faker->optional()->boolean,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
