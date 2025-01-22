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
        Schema::create('client_values', function (Blueprint $table) {
			$table->increments('id')->comment('Identificador de la tabla de client_values');

            //Llaves foráneas
            $table->integer('client_id')->unsigned()->comment('Llave foránea de clients');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->integer('client_attribute_id')->unsigned()->comment('Llave foránea de client_attributes');
            $table->foreign('client_attribute_id')->references('id')->on('client_attributes');

            //
            $table->string('value')->comment('Valor del atributo');

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
        Schema::dropIfExists('client_values');
    }
};
