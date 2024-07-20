<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Leader;

class LeadersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leaders = [
            'Mwenyekiti wa Kijiji/Mtaa',
            'Diwani wa Kata',
            'Mwenyekiti wa Halmashauri/Meya',
            'Mkurugenzi wa Halmashauri',
            'Mkuu wa Wilaya',
            'Mkuu wa Mkoa',
            'Waziri',
            'Waziri Mkuu',
            'Rais',
        ];

        foreach ($leaders as $leaderTitle) {
            Leader::create([
                'name' => $leaderTitle,
            ]);
        }
    }
}
