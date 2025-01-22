<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('suppliers', function (Blueprint $table) {
			$table->smallInteger('commission_percentage')->default(12)->comment('Porcentaje de comisión que se queda la tienda del recovequero');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('suppliers', function (Blueprint $table) {
			$table->dropColumn('commission_percentage');
        });

    }
};
