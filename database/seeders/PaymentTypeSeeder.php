<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentType;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		PaymentType::create([
			"id" => 1,
			"name" => "Efectivo",
			"description" => "Efectivo",
		]);
		PaymentType::create([
			"id" => 2,
			"name" => "Tarjeta de crédito",
			"description" => "Tarjeta de crédito",
		]);
		PaymentType::create([
			"id" => 3,
			"name" => "Tarjeta de regalo",
			"description" => "Tarjeta de regalo",
		]);
		PaymentType::create([
			"id" => 4,
			"name" => "Tarjeta de puntos",
			"description" => "Tarjeta de puntos",
		]);
    }
}
