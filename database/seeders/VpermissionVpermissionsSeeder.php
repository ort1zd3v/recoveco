<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VpermissionVpermission;

class VpermissionVpermissionsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		VpermissionVpermission::create(["entity_id" => "1", "tablename_id" => "2", "attribute_name" => "user_id"]);
	}
}
