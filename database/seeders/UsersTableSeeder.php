<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gabrielpro.nl',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
            'country' => $faker->country,
            'region' => $faker->state,
            'ward' => $faker->city,
            'street' => $faker->streetAddress,
            'remember_token' => Str::random(10),
            'current_team_id' => null, // Adjust as needed
            'profile_photo_path' => $faker->imageUrl(400, 400, 'people', true, 'Faker'), // Optional
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach (range(1, 20) as $index) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // password
                'role' => $faker->randomElement(['citizen', 'leader', 'admin']),
                'country' => $faker->country,
                'region' => $faker->state,
                'ward' => $faker->city,
                'street' => $faker->streetAddress,
                'remember_token' => Str::random(10),
                'current_team_id' => null, // Adjust as needed
                'profile_photo_path' => $faker->imageUrl(400, 400, 'people', true, 'Faker'), // Optional
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
