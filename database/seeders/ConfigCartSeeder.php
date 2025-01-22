<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ConfigCart;

class ConfigCartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		ConfigCart::create([
            "data" => json_encode([
                "pay_inline" => false,
				"in_modal" => true,
            ])
        ]);
    }
}
