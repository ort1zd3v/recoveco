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
        Schema::create('payments', function (Blueprint $table) {
			$table->increments('id')->comment('Identificador de la tabla de payment_types');

            //Llaves foráneas
            $table->integer('payment_type_id')->unsigned()->comment('Llave foránea de payments');
            $table->foreign('payment_type_id')->references('id')->on('payment_types');
            $table->integer('selling_id')->unsigned()->comment('Llave foránea de sellings');
            $table->foreign('selling_id')->references('id')->on('sellings');

            //
            $table->string('amount')->comment('Cantidad de la venta');

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
        Schema::dropIfExists('payments');
    }
};
