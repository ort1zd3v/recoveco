<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RUNONETIME extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call([
			PermissionModuleSeeder::class,
			PermissionModule2Seeder::class,
			PermissionModule3Seeder::class,
			PermissionModule4Seeder::class,
			PermissionModule5Seeder::class,

			PermissionFunctionSeeder::class,
			PermissionFunction2Seeder::class,
			PermissionFunction3Seeder::class,
			PermissionFunction4Seeder::class,
			PermissionFunction5Seeder::class,

			PermissionPermissionSeeder::class,
			PermissionPermission2Seeder::class,
			PermissionPermission3Seeder::class,
			PermissionPermission4Seeder::class,
			PermissionPermission5Seeder::class,
			PermissionPermission6Seeder::class,

			PermissionPermissionRoleSeeder::class,
			PermissionPermissionRole2Seeder::class,
			PermissionPermissionRole3Seeder::class,
			PermissionPermissionRole4Seeder::class,

		
			MainmenuViewnameSeeder::class,
			MainmenuViewname2Seeder::class,
			MainmenuViewname3Seeder::class,
			MainmenuViewname4Seeder::class,
			MainmenuViewname5Seeder::class,

			MainmenuMainmenuSeeder::class,
		]);
	}
}
