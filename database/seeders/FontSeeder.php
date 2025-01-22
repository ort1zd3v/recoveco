<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Font;

class FontSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Font::create(["name" => "'Poppins', sans-serif"]);
        Font::create(["name" => "Arial, Helvetica, sans-serif"]);
        Font::create(["name" => "'Times New Roman', Times, serif"]);
        Font::create(["name" => "'Courier New', Courier, monospace"]);
    }
}
