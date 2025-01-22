<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;

class PermissionModule070524Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()//multiSaveInventory
    {
        $module = PermissionModule::where("name", "inventories")->first();
		PermissionModule::create(["name" => "save_multi_inventories", "module_type_id" => 2, "module_id" => $module->id]);
    }
}
