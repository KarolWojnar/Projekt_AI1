<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class LoansMoviesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = storage_path('csv/loansMovies.csv');
        $data = File::get($path);
        $rows = explode("\n", $data);
        foreach($rows as $row) {
            $values = str_getcsv($row, ';');
            if (isset($values[1])) {
                DB::table('loan_movie')->insert([
                    'id' => $values[0],
                    'loan_id' => $values[1],
                    'movie_id' => $values[2],
                ]);
            }
        }
    }
}
