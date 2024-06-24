<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Wizara ya Fedha na Mipango',
            'Wizara ya Mambo ya Nje na Ushirikiano wa Afrika Mashariki',
            'Wizara ya Mambo ya Ndani ya Nchi',
            'Wizara ya Ulinzi na Jeshi la Kujenga Taifa',
            'Wizara ya Katiba na Sheria',
            'Wizara ya Ardhi, Nyumba na Maendeleo ya Makazi',
            'Wizara ya Maliasili na Utalii',
            'Wizara ya Nishati',
            'Wizara ya Maji',
            'Wizara ya Kilimo',
            'Wizara ya Afya',
            'Wizara ya Elimu, Sayansi na Teknolojia',
            'Wizara ya Ujenzi na Uchukuzi',
            'Wizara ya Habari, Utamaduni, Sanaa na Michezo',
            'Wizara ya Mifugo na Uvuvi',
            'Wizara ya Viwanda na Biashara',
            'Wizara ya Mawasiliano na Teknolojia ya Habari',
            'Wizara ya Madini',
            'Wizara ya Kazi, Ajira, Vijana na Watu Wenye Ulemavu',
            'Wizara ya Tawala za Mikoa na Serikali za Mitaa (TAMISEMI)',
            'Wizara ya Uwekezaji, Viwanda na Biashara',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
            ]);
        }
    }
}
