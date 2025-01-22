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
        Schema::create('starting_founds', function (Blueprint $table) {
            $table->id();
            $table->float('amount', 10, 4)->comment('Dinero inicial del día');
            $table->timestamp('initial_date', 0)->nullable()->comment('Fecha inicial');
			$table->timestamp('final_date', 0)->nullable()->comment('Fecha de cierre');

			$table->smallInteger('initial_user_id')->unsigned()->nullable()->comment('Quien inició el día');
			$table->foreign('initial_user_id')->references('id')->on('users');

			$table->smallInteger('final_user_id')->unsigned()->nullable()->comment('Fecha finalizó el día');
			$table->foreign('final_user_id')->references('id')->on('users');


			//Datos de creación y modificación
			$table->string('notes', 1024)->nullable()->comment('Notas');    
			$table->boolean('is_active')->default(1)->comment('Muestra si la fila está activa');
			$table->smallInteger('created_by')->unsigned()->nullable()->comment('Usuario que creó');
			$table->foreign('created_by')->references('id')->on('users');
			$table->smallInteger('updated_by')->unsigned()->nullable()->comment('Último usuario que modificó');
			$table->foreign('updated_by')->references('id')->on('users');
			$table->timestamp('created_at', 0)->useCurrent()->comment('Fecha de creación');
			$table->timestamp('updated_at', 0)->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment('Última fecha de modificación');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('starting_founds');
    }
};
