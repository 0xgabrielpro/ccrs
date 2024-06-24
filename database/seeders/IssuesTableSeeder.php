<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Issue;
use App\Models\User;
use App\Models\Category;
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
        $categories = Category::pluck('id');

        if ($users->count() === 0) {
            $this->command->info('Please create some users first!');
            return;
        }

        foreach ($users as $user) {
            for ($i = 0; $i < 4; $i++) {
                $status = $faker->randomElement(['open', 'inprogress', 'resolved', 'closed']);
                $citizenSatisfied = $faker->optional()->boolean;

                $issue = new Issue([
                    'user_id' => $user->id,
                    'title' => $faker->sentence,
                    'description' => $faker->paragraph,
                    'category_id' => $categories->random(), 
                    'status' => $status,
                    'citizen_satisfied' => $citizenSatisfied,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $issue->sealed_by = $user->id;
                $issue->to_user_id = $users->random()->id;
                $issue->file_path = $faker->imageUrl(); // Example file path, adjust as needed

                $issue->save();
            }
        }
    }
}
