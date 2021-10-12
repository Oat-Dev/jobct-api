<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\area\AreaGeographySeeder;
use Database\Seeders\area\AreaProvinceSeeder;
use Database\Seeders\area\AreaDistrictsSeeder;
use Database\Seeders\area\AreaSubDistrictSeeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AreaGeographySeeder::class,
            AreaProvinceSeeder::class,
            AreaDistrictsSeeder::class,
            AreaSubDistrictSeeder::class
        ]);
    }
}
