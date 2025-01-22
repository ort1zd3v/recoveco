<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InventoryMovementType;

class InventoryMovementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InventoryMovementType::create(["name" => "Agregar inventario"]);
        InventoryMovementType::create(["name" => "Venta"]);
        InventoryMovementType::create(["name" => "Devolución sobre compra"]);
        InventoryMovementType::create(["name" => "Devolución sobre venta"]);
        InventoryMovementType::create(["name" => "Merma"]);
    }
}
