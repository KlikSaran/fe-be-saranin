<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product; // Make sure this path is correct for your Product model
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = database_path('data/Product.csv');

        if (!File::exists($csvFile)) {
            $this->command->error("Product.csv not found at: {$csvFile}");
            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('products')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $file = fopen($csvFile, 'r');

        $header = fgetcsv($file);

        $data = [];
        while (($row = fgetcsv($file)) !== FALSE) {
            $rowData = array_combine($header, $row);
            $data[] = $rowData;
        }

        fclose($file);

        foreach (array_chunk($data, 1000) as $chunk) {
            Product::insert($chunk);
        }

        $this->command->info('Products seeded successfully from Product.csv!');
    }
}
