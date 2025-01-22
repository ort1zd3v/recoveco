<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ConfigPos;

class ConfigPosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConfigPos::create([
            "data" => json_encode([
                "with_filters" => "on",
				"with_keyboard" => "on",
				"type_box" => "both",
				"tiles" => [
					"tile1" => "productos",
					"tile2" => "carrito",
				],
				"qty" => null,
				"total_rows" => "1",
				"total_columns" => "2",
				"num_section" => "1",
            ])
        ]);

		
    }
}
