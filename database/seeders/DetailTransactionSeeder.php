<?php

namespace Database\Seeders;

use App\Models\DetailTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DetailTransactionSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = database_path('data/Detailed Transaction.csv');

        if (!File::exists($csvFile)) {
            $this->command->error("Detailed Transaction.csv not found at: {$csvFile}");
            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('detail_transactions')->truncate();

        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $file = fopen($csvFile, 'r');

        $header = fgetcsv($file);

        $data = [];
        while (($row = fgetcsv($file)) !== FALSE) {
            $rowData = array_combine($header, $row);
            $data[] = $rowData;
        }

        fclose($file);

        foreach (array_chunk($data, 1000) as $chunk) {
            DetailTransaction::insert($chunk);
        }

        $this->command->info('Detail transaction seeded successfully from Detailed Transaction.csv!');
    }
}
