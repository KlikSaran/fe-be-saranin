<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = database_path('data/Transaction.csv');

        if (!File::exists($csvFile)) {
            $this->command->error("Transaction.csv not found at: {$csvFile}");
            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('transactions')->truncate();

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
            Transaction::insert($chunk);
        }

        $this->command->info('Transaction seeded successfully from Transaction.csv!');
    }
}
