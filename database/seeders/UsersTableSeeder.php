<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = database_path('data/User.csv');

        if (!File::exists($csvFile)) {
            $this->command->error("File User.csv tidak ditemukan pada: {$csvFile}");
            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $file = fopen($csvFile, 'r');

        $header = fgetcsv($file);
        if ($header === false) {
            $this->command->error("File CSV kosong atau tidak dapat membaca header.");
            fclose($file);
            return;
        }

        $dataToInsert = [];
        while (($row = fgetcsv($file)) !== FALSE) {
            if (count($header) !== count($row)) {
                $this->command->warn("Jumlah kolom tidak cocok antara header dan baris data. Baris dilewati: " . implode(',', $row));
                continue;
            }
            $rowData = array_combine($header, $row);

            if (isset($rowData['password'])) {
                $passwordInfo = Hash::info($rowData['password']);
                if ($passwordInfo['algoName'] === 'unknown') {
                    $rowData['password'] = Hash::make($rowData['password']);
                }
            }

            $dataToInsert[] = $rowData;
        }

        fclose($file);

        foreach (array_chunk($dataToInsert, 500) as $chunk) {
            User::insert($chunk);
        }

        User::create([
            'fullname' => 'Admin',
            'email' => 'admin@gmail.com',
            'gender' => 'Male',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $this->command->info('Seeding tabel users dari User.csv berhasil!');
        $this->command->info('User admin berhasil dibuat!');
    }
}
