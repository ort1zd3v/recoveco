<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UnitType;

class UnitTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		UnitType::create(['id' => 1, "name" => "Gr"]);
        UnitType::create(['id' => 2, "name" => "Ml"]);
		UnitType::create(['id' => 4, "name" => "Pza"]);
		UnitType::create(['id' => 5, "name" => "Oz"]);
		UnitType::create(['id' => 6, "name" => "N/A"]);

    }
}
