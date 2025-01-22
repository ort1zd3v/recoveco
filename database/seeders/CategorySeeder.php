<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Category::create([
			"category_id" => null,
			"name" => "Producto",
			"print_order" => 1,
			"is_visible" => 0,
		]);
		Category::create([
			"category_id" => null,
			"name" => "Servicio",
			"print_order" => 2,
			"is_visible" => 0,
		]);
    }
}