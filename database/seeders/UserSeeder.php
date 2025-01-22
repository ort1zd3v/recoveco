<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		$table_user = array(
			array('id' => '9','username' => 'Barby','password' => 'Felizfeliz','name' => 'Barby','surname' => 'Fernández','starDate' => '2017-10-16 00:00:00','address' => NULL,'phone' => NULL,'cellphone' => NULL,'email' => NULL,'level' => '2'),
			array('id' => '16','username' => 'Ale','password' => 'Soyfeliz','name' => 'Ale','surname' => 'Fraga','starDate' => '2019-06-27 00:00:00','address' => NULL,'phone' => NULL,'cellphone' => NULL,'email' => NULL,'level' => '1'),
			array('id' => '18','username' => 'Fabiola','password' => 'Soyfeliz','name' => 'Fabiola','surname' => 'Mtz','starDate' => '2023-05-08 00:00:00','address' => '2056','phone' => NULL,'cellphone' => NULL,'email' => NULL,'level' => '1')
		  );
		  

		// Iterar por cada elemento del array y crear un registro en la base de datos
		foreach ($table_user as $item) {
			User::create([
				"name" => $item['name'],
				"paternal_surname" => $item["surname"],
				"maternal_surname" => "",
				"email" => $item['username']."@example.com",
				"password" => bcrypt($item['password']),
				"role_id" => $item['level'] == 1 ? 2 : 1,
				"created_at" => date("Y-m-d H:i:s"),
				"updated_at" => date("Y-m-d H:i:s"),
			]);
		}

		User::create([
			"name" => "User",
			"paternal_surname" => "Paternal",
			"maternal_surname" => "Maternal",
			"email" => "user@example.com",
			"password" => bcrypt('secret'),
			"role_id" => 1,
			"created_at" => date("Y-m-d H:i:s"),
			"updated_at" => date("Y-m-d H:i:s"),
		]);
	}
}
