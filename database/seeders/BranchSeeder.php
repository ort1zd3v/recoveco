<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$table_sucursal = array(
			array('id' => '1','description' => 'Tauro','idGroup' => '1','creationDate' => '2015-12-11 17:07:46','notes' => ''),
			array('id' => '2','description' => 'Puentes','idGroup' => '1','creationDate' => '2015-12-11 17:07:50','notes' => ''),
			array('id' => '3','description' => 'Contry','idGroup' => '2','creationDate' => '2015-12-11 17:07:52','notes' => ''),
			array('id' => '4','description' => 'Apodaca','idGroup' => '3','creationDate' => '2015-12-11 17:07:55','notes' => ''),
			array('id' => '5','description' => 'Carretera','idGroup' => '4','creationDate' => '2015-12-11 17:07:46','notes' => ''),
			array('id' => '6','description' => 'Cumbres','idGroup' => '5','creationDate' => '2015-12-11 17:07:50','notes' => ''),
			array('id' => '7','description' => 'Anahuac','idGroup' => '6','creationDate' => '2015-12-11 17:07:52','notes' => ''),
			array('id' => '8','description' => 'Pastora','idGroup' => '7','creationDate' => '2015-12-11 17:07:55','notes' => ''),
			array('id' => '9','description' => 'PH Anahuac','idGroup' => '8','creationDate' => '2015-12-11 17:07:55','notes' => '')
		);
		
		foreach ($table_sucursal as $row){
			Branch::create([
				'name' => $row["description"],
				'group' => $row["idGroup"],
			]);
		}
	}
}
