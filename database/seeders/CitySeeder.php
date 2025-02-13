<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $filePath = database_path('seeders/cities.csv'); // file is placed in database/seeders

        $cities = [];
        if (($handle = fopen($filePath, "r")) !== FALSE) {
            $header = fgetcsv($handle); // Read and ignore header row

            while (($row = fgetcsv($handle)) !== FALSE) {
                $cities[] = [
                    'id' => $row[0],          // CSV column index for 'id'
                    'name' => $row[1],        // CSV column index for 'name'
                    'province_id' => $row[2], // CSV column index for 'province_id'
                ];
            }
            fclose($handle);
        }

        DB::table('cities')->insert($cities);
    }
}