<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClientAttribute;

class ClientAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClientAttribute::create([
            "name" => "apellidos",
            "description" => "Apellidos del cliente, ejemplo: Herrera Valles",
            "is_required" => 1
        ]);

        ClientAttribute::create([
            "name" => "correo electrónico",
            "description" => "Correo electrónico del cliente, ejemplo: cliente@outlook.com",
            "is_required" => 0
        ]);
    }
}
