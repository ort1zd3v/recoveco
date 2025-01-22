<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ConfigProduct;

class ConfigProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConfigProduct::create([
            "data" => json_encode([
                "with_tabs" => false,
				"with_filters"=>  true,
				"type_box"=>  "both",
				"with_keyboard"=>  false,
			])
        ]);
    }
}
