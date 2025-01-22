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
		Schema::create('permission_modules', function (Blueprint $table) {
			$table->smallIncrements('id');
			$table->string('name');
			$table->smallInteger('module_id')->unsigned()->nullable();
			$table->foreign('module_id')->references('id')->on('permission_modules')->onDelete('restrict');
			$table->tinyInteger('module_type_id')->unsigned();
			$table->foreign('module_type_id')->references('id')->on('permission_module_types')->onDelete('restrict');
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
		Schema::dropIfExists('permission_modules');
	}
};