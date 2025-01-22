<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MainmenuMainmenu;
use App\Models\MainmenuViewname;

class MainmenuMainmenu2Seeder extends MainmenuMainmenuSeeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{

		$this->createSubmenu('inventories', 'add_inventories', "<i class='bx bx-package'></i>");
		$this->createSubmenu('reports', 'report_by_sellings', "<i class='bx bxs-report'></i>");
	}
}
