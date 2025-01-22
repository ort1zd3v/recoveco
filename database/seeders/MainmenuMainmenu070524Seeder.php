<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MainmenuMainmenu;
use App\Models\MainmenuViewname;

class MainmenuMainmenu070524Seeder extends MainmenuMainmenuSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createSubmenu('inventories', 'save_multi_inventories', "<i class='bx bx-package'></i>");
    }
}
