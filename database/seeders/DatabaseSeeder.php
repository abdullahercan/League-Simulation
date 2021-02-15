<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\Week;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // Teams Seeder
        Team::insert([
            [
                'name' => 'Manchester City',
                'logo' => 'ManchesterCity.png',
            ],
            [
                'name' => 'Manchester United',
                'logo' => 'ManchesterUnited.png',
            ],
            [
                'name' => 'Leicester City',
                'logo' => 'LeicesterCity.png',
            ],
            [
                'name' => 'Manchester City',
                'logo' => 'ManchesterCity.png',
            ],
            [
                'name' => 'Liverpool',
                'logo' => 'Liverpool.png'
            ],
            [
                'name' => 'Arsenal',
                'logo' => 'Arsenal.png'
            ]
        ]);

        //Weeks Seeder
        Week::insert([
            [
                'name' => '1 st'
            ],
            [
                'name' => '2 nd'
            ],
            [
                'name' => '3 rd'
            ],
            [
                'name' => '4 th'
            ],
            [
                'name' => '5 th'
            ],
            [
                'name' => '6 th'
            ],
            [
                'name' => '7 th'
            ],
            [
                'name' => '8 th'
            ]
        ]);
    }
}
