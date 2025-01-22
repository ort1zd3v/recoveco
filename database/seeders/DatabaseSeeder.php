<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call([
			RoleSeeder::class,
			UserSeeder::class,
			

			//Mod permissions
			PermissionModuleTypeSeeder::class,
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

			//Modulo demulti inventarios
			PermissionFunction070524Seeder::class,
			PermissionModule070524Seeder::class,
			PermissionPermission070524Seeder::class,
			PermissionPermissionRole070524Seeder::class,
			MainmenuViewname070524Seeder::class,
			MainmenuMainmenu070524Seeder::class,
			
			//Mod mainmenu
			MainmenuMainmenuStatusSeeder::class,
			MainmenuViewnameSeeder::class,
			MainmenuViewname2Seeder::class,
			MainmenuViewname3Seeder::class,
			MainmenuViewname4Seeder::class,
			MainmenuViewname5Seeder::class,

			MainmenuMainmenuSeeder::class,
			MainmenuMainmenu2Seeder::class,

			//Mod vpermissions
			VpermissionTablenamesSeeder::class,
			VpermissionVpermissionsSeeder::class,

			//Supliers
			SupplierSeeder::class,


			//Products
			CategorySeeder::class,
			UnitTypeSeeder::class,
			ProductSeeder::class,

			//Templates
			TemplateSeeder::class,

			//Config Pos
			ConfigPosSeeder::class,
			ConfigProductSeeder::class,
			ConfigCartSeeder::class,
			ConfigPaymentSeeder::class,
			ConfigTicketSeeder::class,

			//Fonts
			FontSeeder::class,

			//Clients
			ConfigClientSeeder::class,
			BranchSeeder::class,
			ClientSeeder::class,
			ClientAttributeSeeder::class,
			ClientValueSeeder::class,

			IngredientSeeder::class,

			PaymentTypeSeeder::class,

			//Initial cash
			StartingFoundSeeder::class,

			InventoryMovementTypeSeeder::class,
			InventoryMovementType2Seeder::class,
			
			InventorySeeder::class,


			SellingSeeder::class,
			SellingRowSeeder::class,
			PaymentSeeder::class,
			Supplier2Seeder::class,


		]);
	}
}
