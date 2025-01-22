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
        Schema::create('products', function (Blueprint $table) {
			$table->increments('id')->comment('Identificador de la tabla de products');
            
            //Llaves foráneas
            $table->smallInteger('unit_type_id')->unsigned()->comment('Llave foránea de unit_types');
            $table->foreign('unit_type_id')->references('id')->on('unit_types');
            $table->smallInteger('category_id')->unsigned()->comment('Llave foránea de categories');
            $table->foreign('category_id')->references('id')->on('categories');
			$table->integer('supplier_id')->nullable()->unsigned()->comment('Llave foránea de suppliers');
            $table->foreign('supplier_id')->references('id')->on('suppliers');

            //
            $table->string('name')->comment('Nombre del producto que aparece en el ticket');
			$table->string('display_name')->nullable()->comment('Nombre del producto que se muestra en la selección de productos (para cuando es muy largo aquí se recorta)');

            $table->string('barcode')->comment('Código de barras del producto');
            $table->string('color')->comment('Color del producto');
            $table->string('url_image')->comment('Url de la imágen a mostrar');
            $table->float('print_order')->comment('Orden de impresión');
            $table->float('iva')->comment('Porcemtaje del IVA');
            $table->float('cost_base', 10, 4)->comment('Costo del producto');
            $table->float('cost_min', 10, 4)->comment('Costo del producto');
            $table->float('cost_max', 10, 4)->comment('Costo del producto');
            $table->float('price_base', 10, 4)->comment('Precio del producto');
            $table->float('price_min', 10, 4)->comment('Precio del producto');
            $table->float('price_max', 10, 4)->comment('Precio del producto');
			$table->float('overprice', 10, 4)->default(0)->comment('Precio extra del producto en caso de ser ingrediente (aplicable en rompope)');

            $table->boolean('is_saleable')->comment('Esta a la venta');
            $table->boolean('is_ticketable')->comment('Tiene ticket');
            $table->boolean('is_discountable')->comment('Se descuenta de inventario');
            $table->boolean('is_favorite')->comment('Esta en favoritos');
            $table->boolean('is_consigment')->comment('Esta consignado');
            $table->boolean('is_product')->comment('Es un producto');

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
        Schema::dropIfExists('products');
    }
};
