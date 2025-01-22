<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ConfigTicket;

class ConfigTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		ConfigTicket::create([
            "url_logo" => "images/logos/yt5YT8pGH5aWTMlqXLZRDUabfEnjFQZSKtEX4rPn.png",
			"header" => "<p>Raspados y Helados de Yogurth</p>
			<p>Av. Tauro 205 Local 1 Nueva Linda Vista</p>
			<p>Guadalupe, Nuevo León</p>
			<p>CP 67110</p>
			<p>RFC RORP660605NJA</p>",
            "footer" => "<p><b>¡Gracias, vuelve pronto!</b></p>
			<p><b>Reg&iacute;strate en:</b></p>
			<p><b>www.gelow.com.mx</b></p>",
            "footer2" => "<p><b>Gelow</b></p>
			<p><b>Contraseña: Gelowmango</b></p>",
        ]);
    }
}







