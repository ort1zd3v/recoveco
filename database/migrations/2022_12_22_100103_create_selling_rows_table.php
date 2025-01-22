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
        Schema::create('selling_rows', function (Blueprint $table) {
			$table->increments('id')->comment('Identificador de la tabla de selling_rows');

            //Llaves foráneas
            $table->integer('selling_id')->unsigned()->comment('Llave foránea de sellings');
            $table->foreign('selling_id')->references('id')->on('sellings');
            $table->integer('product_id')->unsigned()->comment('Llave foránea de products');
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('parent_product_id')->nullable()->unsigned()->comment('Producto al que pertenece');
            $table->foreign('parent_product_id')->references('id')->on('products');

            //
            $table->string('description')->nullable()->comment('Descripción de la venta');
            $table->string('amount')->comment('Cantidad del producto vendido');
            $table->float('unit_price', 12, 4)->comment('Precio unitario del producto');
			$table->float('subtotal', 12, 4)->comment('Subtotal (precio por cantidad)');
            $table->float('iva', 12, 4)->comment('Cantidad del IVA');
            $table->float('total_price', 12, 4)->comment('Subtotal más IVA');

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
        Schema::dropIfExists('selling_rows');
    }
};
