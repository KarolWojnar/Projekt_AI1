<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OpinionsSeeder extends Seeder
{
    public function run(): void
    {
        $path = storage_path('csv/opinions.csv');
        $data = File::get($path);
        $rows = explode("\n", $data);
        $startDate = Carbon::parse('2022-01-01');
        $endDate = Carbon::now();
        foreach($rows as $row) {
            $values = str_getcsv($row, ';');
            if (isset($values[1])) {
                $randomDays = rand(0, $startDate->diffInDays($endDate));
                $randomDate = $startDate->addDays($randomDays);
                $randomTime = rand(0, 23);
                $randomMinute = rand(0, 59);
                $randomDate = $randomDate->setTime($randomTime, $randomMinute);
                DB::table('opinions')->insert([
                    'id' => $values[0],
                    'user_id' => $values[1],
                    'movie_id' => $values[2],
                    'content' => $values[3],
                    'created_at' => $randomDate,
                ]);
            }
        }
    }
}
