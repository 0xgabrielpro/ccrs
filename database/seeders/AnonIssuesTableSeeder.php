<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnonIssue;
use Illuminate\Support\Str;

class AnonIssuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        foreach (range(1, 10) as $index) {
            AnonIssue::create([
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'country_id' => 1,
                'region_id' => 1,
                'district_id' => 1,
                'ward_id' => 1,
                'street_id' => 1,
                'category_id' => 1,
                'read' => false,
                'to_user_id' => null,
                'sealed_by' => null,
                'citizen_satisfied' => null, 
                'status' => $faker->randomElement(['open', 'inprogress', 'closed', 'resolved']),
                'file_path' => $faker->optional()->randomElement(['file1.pdf', 'file2.docx', null]),
                'code' => Str::random(10),
                'visibility' => $faker->boolean(70), // 70% chance of visibility being true (1)
            ]);
        }
    }
}
