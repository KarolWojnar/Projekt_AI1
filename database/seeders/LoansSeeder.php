<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class LoansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = storage_path('csv/loans.csv');
        $data = File::get($path);
        $rows = explode("\n", $data);
        foreach($rows as $row) {
            $values = str_getcsv($row, ';');
            if (isset($values[1])) {
                $startLoan = date('Y-m-d', strtotime($values[1]));
                $endLoan = date('Y-m-d', strtotime($values[2]));
                DB::table('loans')->insert([
                    'id' => $values[0],
                    'start_loan' => $startLoan,
                    'end_loan' => $endLoan,
                    'price' => $values[3],
                    'status' => $values[4],
                    'user_id' => $values[5],
                ]);
            }
        }
    }
}
