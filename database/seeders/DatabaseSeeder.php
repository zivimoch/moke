<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        //data user
        $csvFile = fopen(base_path("database/data/users.csv"), "r");
        $firstline = true;
        while (($users = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                User::create([
                    "id" => $users['0'],
                    "uuid" => $users['1'],
                    "name" => $users['2'],
                    "kotkab_id" => $users['3'],
                    "email" => $users['4'],
                    "email_verified_at" => Carbon::now(),
                    "jabatan" => $users['6'],
                    // "supervisor_layanan" => 0,
                    "supervisor_id" => $users['7'],
                    "password" => $users['8'],
                    "remember_token" => NULL,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "deleted_at" => NULL,
                ]);    
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}
