<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Leader; 

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
        
        // Create an anonymous citizen
        User::create([
            'name' => 'Anonymous',
            'email' => 'anon@anonymous.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'citizen',
            'country' => $faker->country,
            'region' => $faker->state,
            'ward' => $faker->city,
            'street' => $faker->streetAddress,
            'remember_token' => Str::random(10),
            'current_team_id' => null,
            'profile_photo_path' => $faker->imageUrl(400, 400, 'people', true, 'Faker'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Create an admin user
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
            'current_team_id' => null,
            'profile_photo_path' => $faker->imageUrl(400, 400, 'people', true, 'Faker'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $leaders = Leader::all();

        foreach (range(1, 20) as $index) {
            $user = User::create([
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
                'current_team_id' => null,
                'profile_photo_path' => "https://0xgabrielpro.github.io/test/profile.jpeg",
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($user->role === 'leader') {
                if ($leaders->count() > 0) {
                    $user->leader_id = $leaders->random()->id;
                } 
                else {
                    $user->leader_id = rand(1, 9);
                }
                $user->save();
            }
        }
    }
}
