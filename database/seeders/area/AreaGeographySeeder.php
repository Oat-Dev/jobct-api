<?php

namespace Database\Seeders\Area;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaGeographySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path('database/seeders/area/area_geography.sql');
        DB::unprepared(file_get_contents($path));
    }
}
