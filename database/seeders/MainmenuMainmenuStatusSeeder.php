<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MainmenuMainmenuStatus;

class MainmenuMainmenuStatusSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		MainmenuMainmenuStatus::create(["name" => "active"]);
		MainmenuMainmenuStatus::create(["name" => "inactive"]);
	}
}
