<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\Region;
use App\Models\District;
use App\Models\Ward;
use App\Models\Street;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Step 1: Create the country
        $country = Country::firstOrCreate(['name' => 'Tanzania']);

        // Step 2: Create the region
        $region = Region::firstOrCreate(['name' => 'Arusha', 'country_id' => $country->id]);

        // Step 3: Create the district
        $district = District::firstOrCreate(['name' => 'Arusha CBD', 'region_id' => $region->id]);

        // Step 4: Create the ward
        $ward = Ward::firstOrCreate(['name' => 'Muriet', 'district_id' => $district->id]);

        // Step 5: Create the streets
        $streets = [
            'Bondeni',
            'Eluanyi',
            'Embararwai',
            'FFU',
            'Kati',
            'Mashariki',
            'Mlimani',
            'Msasani',
            'Murieti',
            'Nadosoito Kusini',
            'Ngorienito',
            'Oldonyokumur'
        ];

        foreach ($streets as $streetName) {
            Street::firstOrCreate(['name' => $streetName, 'ward_id' => $ward->id]);
        }
    }
}
