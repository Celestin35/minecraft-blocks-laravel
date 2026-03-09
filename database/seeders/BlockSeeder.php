<?php

namespace Database\Seeders;

use App\Models\Block;
use Illuminate\Database\Seeder;

class BlockSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/blocks_extended.csv');

        $file = fopen($path, 'r');

        $headers = fgetcsv($file);
        if ($headers === false) {
            fclose($file);
            return;
        }

        while (($row = fgetcsv($file, 1000, ',')) !== false) {
            $data = array_combine($headers, $row);
            if ($data === false) {
                continue;
            }

            Block::updateOrCreate(
                [
                    'file_name' => $data['file_name'] ?? null,
                ],
                [
                    'block_name' => $data['block_name'] ?? null,
                    'variant' => $data['variant'] ?? null,
                    'avg_color_srgb' => $data['avg_color_srgb'] ?? null,
                    'avg_color_linear' => $data['avg_color_linear'] ?? null,
                    'category' => $data['category'] ?? null,
                    'family' => $data['family'] ?? null,
                    'material' => $data['material'] ?? null,
                    'is_transparent' => filter_var($data['is_transparent'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'is_solid' => filter_var($data['is_solid'] ?? true, FILTER_VALIDATE_BOOLEAN),
                    'detail_form' => $data['detail_form'] ?? null,
                    'detail_flammable' => filter_var($data['detail_flammable'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'detail_interactive' => filter_var($data['detail_interactive'] ?? false, FILTER_VALIDATE_BOOLEAN),
                ]
            );
        }

        fclose($file);
    }
}
