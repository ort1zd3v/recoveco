<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionPermission070524Seeder extends PermissionPermissionSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPermissions(["save_multi_inventories"], ['index', 'multiSaveInventories', 'addCartInventory', 'searchProduct'], false);
    }
}
