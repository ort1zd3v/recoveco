<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UnitTypeController;
use App\Http\Controllers\SellingController;
use App\Http\Controllers\StartingFoundController;

use App\Http\Controllers\ConfigGeneralController;
use App\Http\Controllers\ConfigPosController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\ConfigTicketController;

use App\Http\Controllers\ReportByYearController;
use App\Http\Controllers\ReportByMonthController;
use App\Http\Controllers\ReportByDayController;
use App\Http\Controllers\ReportBySupplierController;
use App\Http\Controllers\ReportByTicketController;
use App\Http\Controllers\ReportByPaymentTypeController;
use App\Http\Controllers\ReportBySellingController;

use App\Http\Controllers\PosController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InventoryMovementController;
use App\Http\Controllers\InventoryMovementTypeController;
use App\Http\Controllers\AddInventoryController;
use App\Http\Controllers\InventoryMultiMovementController;

use App\Http\Controllers\SupplierController;
use App\Classes\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__.'/auth.php';
require __DIR__.'/web/permissions.php';



Route::middleware('auth')->group(function () {

	Route::get('report_by_tickets/getTicket/{selling}', [ReportByTicketController::class, 'getTicket'])->name('report_by_tickets.getTicket');
	Route::get('report_by_sellings/exportExcel', [ReportBySellingController::class, 'exportExcel'])->name('report_by_sellings.exportExcel');

	//________________________

	Route::get('/', [HomeController::class, 'index'])->name('home');

	Route::get('report_by_payment_types/getChart', [ReportByPaymentTypeController::class, 'getChart'])->name('report_by_payment_types.getChart');


	Route::get('pos/{uniqueId}/{buttonId}/updateingredientsmodal',  [PosController::class, 'updateIngredientsModal'])->name('pos.updateingredientsmodal');
	Route::post('pos/{product}/{uniqueId}/addIngredientProduct',  [PosController::class, 'addIngredientProduct'])->name('pos.addIngredientProduct');
	
	
	Route::get('suppliers/getbyparam', [SupplierController::class, 'getByParam'])->name('suppliers.getbyparam');
	Route::get('products/getbyparam', [ProductController::class, 'getByParam'])->name('products.getbyparam');

	Route::resourceModals('suppliers',  SupplierController::class);


	Route::post('inventories/insertOrUpdateInventory', [InventoryController::class, 'insertOrUpdateInventory'])->name('inventories.insertOrUpdateInventory');
	Route::resourceModals('inventories',  InventoryController::class);
	Route::resourceModals('inventory_movements',  InventoryMovementController::class);
	Route::resourceModals('save_multi_inventories',  InventoryMultiMovementController::class);
	Route::get('save_multi_inventories/{uniqueId}/{buttonId}/updateingredientsmodal',  [InventoryMultiMovementController::class, 'updateIngredientsModal'])->name('inventories-multi-movements.updateingredientsmodal');
	Route::get('save_multi_inventories/search/{param}',  [InventoryMultiMovementController::class, 'searchProduct'])->name('inventories-multi-movements.index'); //nueva
	Route::post('save_multi_inventories/{product}/{uniqueId}/addIngredientProduct',  [InventoryMultiMovementController::class, 'addIngredientProduct'])->name('inventories-multi-movements.addIngredientProduct');

	Route::middleware(['permissions'])->group(function () {
		Route::get('starting_founds/showCloseDay', [StartingFoundController::class, 'showCloseDay'])->name('starting_founds.closeDay');
		Route::get('starting_founds/showInitDay', [StartingFoundController::class, 'showInitDay'])->name('starting_founds.initDay');

		Route::post('starting_founds/closeDay/{starting_found}', [StartingFoundController::class, 'closeDay'])->name('starting_founds.closeDay');
		Route::post('starting_founds/initDay', [StartingFoundController::class, 'initDay'])->name('starting_founds.initDay');
		Route::get('starting_founds/getTicket/{starting_found}', [StartingFoundController::class, 'getTicket'])->name('starting_founds.getTicket');

		Route::resource('starting_founds',  StartingFoundController::class);
		Route::get('config_pos/getViews',  [ConfigPosController::class, 'getViews'])->name('config_pos.getViews');
		Route::get('config_pos/getView/{view}',  [ConfigPosController::class, 'getView'])->name('config_pos.getView');
		Route::get('config_pos/getConfigView/{view}',  [ConfigPosController::class, 'getConfigView'])->name('config_pos.getConfigView');
		Route::post('config_pos/saveConfigView',  [ConfigPosController::class, 'saveConfigView'])->name('config_pos.saveConfigView');
		Route::get('products/jsonproducts', [ProductController::class, 'jsonProducts'])->name('products.jsonproducts');
		Route::get('products/getproducttableview', [ProductController::class, 'getProductTableView'])->name('products.getproducttableview');
		Route::get('products/getproducttableajax', [ProductController::class, 'getProductTableAjax'])->name('products.getproducttableajax');

		Route::get('products/getbyparam/{id}', [ProductController::class, 'getByParam'])->name('products.getbyparam');
		Route::get('ingredients/getdatatable/{id?}', [IngredientController::class, 'getDataTable'])->name('ingredients.getdatatable');

		Route::middleware(['initialDay'])->group(function () {
			Route::get('/dashboard',  [DashboardController::class, 'index'])->name('dashboard.index');
			Route::post('pos/saveSale', [PosController::class, 'saveSale'])->name('pos.saveSale');
			Route::post('pos/{product}/addcartproduct',  [PosController::class, 'addCartProduct'])->name('pos.addcartproduct');
			Route::get('pos/{product}/getingredientsmodal',  [PosController::class, 'getIngredientsModal'])->name('pos.getingredientsmodal');
			Route::get('pos/search/{param}',  [PosController::class, 'searchProduct'])->name('pos.searchProduct'); //nueva
			Route::resource('pos',  PosController::class);
		});
		
		Route::resource('products',  ProductController::class);
		
		Route::get('categories/getbyparam', [CategoryController::class, 'getByParam'])->name('categories.getbyparam');
		Route::resourceModals('categories',  CategoryController::class);
		Route::resourceModals('unit_types',  UnitTypeController::class);
		Route::resource('ingredients',  IngredientController::class);


		Route::get('templates/updateTheme/{idTemplate}',  [TemplateController::class, 'updateTheme'])->name('templates.updateTheme');
		Route::put('templates/update',  [TemplateController::class, 'update'])->name('templates.update');
		Route::get('config_general/getPreview/{view}/{idTheme}',  [ConfigGeneralController::class, 'getPartOfPreview'])->name('config_general.getPartOfPreview');
		Route::resource('config_general',  ConfigGeneralController::class);

		Route::get('config_tickets/getTicket/{selling_id}', [PosController::class, 'getTicket'])->name('config_tickets.getTicket');
		Route::resource('config_tickets',  ConfigTicketController::class);

		Route::get('config_pos/index',  [ConfigPosController::class, 'index'])->name('config_pos.index');
		Route::put('config_pos/update',  [ConfigPosController::class, 'update'])->name('config_pos.update');
		

		Route::get('clients/getbyparam', [ClientController::class, 'getByParam'])->name('clients.getbyparam');
		Route::resourceModals('clients',  ClientController::class);

		//reports
		Route::resource('sellings',  SellingController::class);


		Route::get('report_by_years/getYearDetail/{year}', [ReportByYearController::class, 'getYearDetail'])->name('report_by_years.getYearDetail');
		Route::get('report_by_years/getByMonth/{year}', [ReportByYearController::class, 'getByMonth'])->name('report_by_years.getByMonth');
		
		Route::get('report_by_months/getMonthDetail/{year}/{month}', [ReportByMonthController::class, 'getMonthDetail'])->name('report_by_months.getMonthDetail');
		Route::get('report_by_months/getByDay/{year}/{month}', [ReportByMonthController::class, 'getByDay'])->name('report_by_months.getByDay');
		Route::get('report_by_days/getDayDetail/{year}/{month}/{day}', [ReportByDayController::class, 'getByDayDetail'])->name('report_by_days.getDayDetail');

		Route::get('report_by_suppliers/getSupplierDetail/{supplier_id}/{start_date}/{end_date}', [ReportBySupplierController::class, 'getSupplierDetail'])->name('report_by_suppliers.getSupplierDetail');
		
		Route::get('report_by_tickets/getTicketDetail/{selling_id}', [ReportByTicketController::class, 'getTicketDetail'])->name('report_by_tickets.getTicketDetail');
		Route::delete('report_by_tickets/cancelSelling/{selling}', [ReportByTicketController::class, 'cancelSelling'])->name('report_by_tickets.cancelSelling');


		Route::resource('report_by_years',  ReportByYearController::class);
		Route::resource('report_by_months',  ReportByMonthController::class);
		Route::resource('report_by_days',  ReportByDayController::class);

		Route::get('report_by_suppliers/exportExcel', [ReportBySupplierController::class, 'exportExcel'])->name('report_by_suppliers.exportExcel');

		Route::resource('report_by_suppliers',  ReportBySupplierController::class);
		Route::resource('report_by_tickets',  ReportByTicketController::class);
		Route::resource('report_by_payment_types',  ReportByPaymentTypeController::class);


		Route::resource('report_by_sellings',  ReportBySellingController::class);

		//inventarios (Agregar nueva vista tipo pos)
		Route::post('add_inventories/saveInventory', [AddInventoryController::class, 'saveInventory'])->name('add_inventories.saveInventory');
		Route::post('add_inventories/{product}/addCartInventory',  [AddInventoryController::class, 'addCartInventory'])->name('add_inventories.addCartInventory');
		Route::get('add_inventories',  [AddInventoryController::class, 'index'])->name('add_inventories.index');

	});

	
});

