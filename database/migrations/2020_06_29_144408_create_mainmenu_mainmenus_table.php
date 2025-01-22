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
		Schema::create('mainmenu_mainmenus', function (Blueprint $table) {
			$table->smallIncrements('id');
			$table->string('name');
			$table->string('description')->nullable();
			$table->string('icon')->nullable();
			$table->string('link')->nullable();
			$table->smallInteger('menu_position')->unsigned();
			$table->smallInteger('mainmenu_status_id')->unsigned();
			$table->foreign('mainmenu_status_id')->references('id')->on('mainmenu_mainmenu_statuses')->onDelete('restrict');
			$table->smallInteger('viewname_id')->unsigned()->nullable()->comment('To link the menu with the permissions');
			$table->foreign('viewname_id')->references('id')->on('mainmenu_viewnames')->onDelete('restrict');
			$table->smallInteger('mainmenu_id')->unsigned()->nullable()->comment('A manu can be nested in another menu');
			$table->foreign('mainmenu_id')->references('id')->on('mainmenu_mainmenus')->onDelete('restrict');
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
		Schema::dropIfExists('mainmenu_mainmenus');
	}
};