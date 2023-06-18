<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MoviesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = storage_path('csv/movies.csv');
        $data = File::get($path);
        $rows = explode("\n", $data);
        foreach($rows as $row) {
            $values = str_getcsv($row, ';');
            if (isset($values[1])) {
                $imagePath = public_path($values[8]);
                $imageData = file_get_contents($imagePath);
                DB::table('movies')->insert([
                    'id' => $values[0],
                    'title' => $values[1],
                    'description' => $values[2],
                    'category_id' => $values[3],
                    'director' => $values[4],
                    'release' => $values[5],
                    'longTime' => $values[6],
                    'rate' => $values[7],
                    'img_path' => $imageData,
                    'pricePerDay' => $values[9],
                    'available' => $values[10],
                ]);
            }
        }
    }
}
