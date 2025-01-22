<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ConfigPayment;

class ConfigPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConfigPayment::create([
            "data" => json_encode([
                "with_cash" => true,
				"with_credit"=>  true,
				"with_gift_card"=>  false,
				"with_points"=>  "false",
			])
        ]);
    }
}
