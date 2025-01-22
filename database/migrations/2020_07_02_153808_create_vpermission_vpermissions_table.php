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
		Schema::create('vpermission_vpermissions', function (Blueprint $table) {
			$table->smallIncrements('id');
			$table->tinyInteger('entity_id')->unsigned()->comment("Tabla en la que se aplicará el filtro de permisos verticales");
			$table->foreign('entity_id')->references('id')->on('vpermission_tablenames')->onDelete('restrict');
			$table->tinyInteger('tablename_id')->unsigned()->comment("Tabla que contendrá el filtro entre la tabla y usuarios");
			$table->foreign('tablename_id')->references('id')->on('vpermission_tablenames')->onDelete('restrict');
			$table->string('attribute_name')->comment("Nombre del attributo en la tabla tablenames que se relacionará hacia el campo id de users");
			$table->timestamp('created_at', 0)->useCurrent();
			$table->timestamp('updated_at', 0)->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('vpermission_vpermissions');
	}
};