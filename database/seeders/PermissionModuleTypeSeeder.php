<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModuleType;

class PermissionModuleTypeSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		PermissionModuleType::create(["name" => "Module"]);
		PermissionModuleType::create(["name" => "view"]);
	}
}
