<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

         // Dodanie rekordu administratora
         DB::table('users')->insert([
            'id' => '1',
            'first_name' => 'Admin',
            'last_name' => 'Adminowski',
            'email' => 'admin@wp.pl',
            'address' => 'Admin Address',
            'city' => 'Admin City',
            'password' => Hash::make('Admin@12345'),
            'late_fee' => '0',
            'isAdmin' => 1,
        ]);

        $path = storage_path('csv/users.csv');
        $data = File::get($path);
        $rows = explode("\n", $data);
        foreach($rows as $row) {
            $values = str_getcsv($row, ';');
            if (isset($values[1])) {
                DB::table('users')->insert([
                    'id' => $values[0],
                    'first_name' => $values[1],
                    'last_name' => $values[2],
                    'email' => $values[3],
                    'address' => $values[4],
                    'city' => $values[5],
                    'password' => Hash::make($values[6]),
                    'late_fee' => $values[7],
                ]);
            }
        }
    }
}
