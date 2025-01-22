<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VpermissionTablename;

class VpermissionTablenamesSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		VpermissionTablename::create(["name" => "sellings"]);
		VpermissionTablename::create(["name" => "selling_user"]);
	}
}
