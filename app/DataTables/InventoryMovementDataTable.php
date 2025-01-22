<?php

namespace App\DataTables;

use App\Models\InventoryMovement;
// use App\Models\User;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class InventoryMovementDataTable extends BlankDataTable
{
	public function __construct()
	{
		$this->my_actions = false;
		$this->routeResource = 'inventory_movements';
	}
	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\Selling $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(InventoryMovement $model)
	{
		return $model->select(
			'inventory_movements.*',
			'inventory_movement_types.name as inventory_movement_type_id_name',
			'products.name as product_name',
			'products.barcode as barcode',
			'suppliers.name as supplier_name',
			'users.name as user_name'
		)
		->orderBy('inventory_movements.created_at', 'desc')
		->leftjoin('inventory_movement_types', 'inventory_movements.inventory_movement_type_id', '=', 'inventory_movement_types.id')
		->leftjoin('products', 'inventory_movements.product_id', '=', 'products.id')
		->leftjoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')		
		->leftjoin('users', 'inventory_movements.created_by', '=', 'users.id')

		->newQuery();
	}

	
	public function getBuilderParameters()
	{	
		$result = parent::getBuilderParameters();
		$result = array_merge($result, 
			[
				'dom' => 'lfBrtip',
				'pageLength' => 15,
				'lengthMenu'=> [
					[15,30,45, 100],
					[15,30,45, 100],
				],
				'columnDefs' => [
					['responsivePriority' => 1, 'targets' => 0],
					['width' => '40%', 'targets' => 1, 'className' => 'text-wrap'],
					['width' => '30%', 'targets' => 2, 'className' => 'text-wrap'],
					['width' => '10%', 'targets' => 3, 'className' => 'text-center'],
					['width' => '10%', 'targets' => 4, 'className' => 'text-end'],
					['width' => '10%', 'targets' => 5, 'className' => 'text-center'],
				],
				'buttons' => [
					['extend' => 'colvis', 'text' => 'Mostrar/Ocultar Columnas', 'className' => 'btn btn-primary'],
					[
						'extend' => 'excel',
						'text' => '<i class="fas fa-file-excel"></i> Exportar a excel',
						'className' => 'btn btn-success',
						'exportOptions' => [
							'columns' => [1, 2, 3, 4] // Aquí especifica los índices de las columnas que deseas exportar
						]
					]
				],
			]
		);

		return $result;
	}

	public function dataTable($query)
	{
		$datatable = parent::dataTable($query);
		$datatable->filter(function($query) {
			if(request('initial_date') !== null && request('final_date') !== null){
				$query->where('inventory_movements.created_at','>=' ,request('initial_date'))
					->where('inventory_movements.created_at','<=' ,request('final_date')." 23:59:59");
			}

			if (request()->inventory_movement_type_id != null && request()->inventory_movement_type_id != "0"){
				$query->where('inventory_movements.inventory_movement_type_id', request()->inventory_movement_type_id);
			}

			if (request()->product_name != null ){
				$query->where('products.name', 'LIKE', '%'.request()->product_name.'%');
			}

			if (request()->supplier_name != null ){
				$query->where('suppliers.name', 'LIKE', '%'.request()->supplier_name.'%');
			}

			if (request()->barcode != null ){
				$query->where('products.barcode', 'LIKE', '%'.request()->barcode.'%');
			}
			

		})->editColumn('is_discountable', function ($row) {
			return $row->is_discountable == 1 ? 'Sí' : 'No';
		})->rawColumns(["url_image", "action", 'color']);
		
		return $datatable;
	}

	/**
	 * Get columns.
	 *
	 * @return array
	 */
	protected function getColumns()
	{
		$pColumns = parent::getColumns();
		$columns = [
			['data' => 'id', 'visible' => false, 'title' => __('inventory_movements.id')],
			['data' => 'barcode', 'title' => __('products.barcode'), 'name' => 'products.name'],
			['data' => 'supplier_name', 'title' => __('suppliers.supplier_name'), 'name' => 'supplier.name'],
			['data' => 'product_name', 'title' => __('inventory_movements.product_id'), 'name' => 'products.name'],
			['data' => 'inventory_movement_type_id_name', 'title' => __('inventory_movements.inventory_movement_type_id'), 'name' => 'inventory_movement_types.name'],
			['data' => 'amount', 'title' => __('inventory_movements.amount')],
			['data' => 'created_at', 'title' => __('inventory_movements.created_at')],
			['data' => 'user_name', 'title' => __('inventory_movements.created_by')],
			['data' => 'is_discountable', 'title' => "Descontable", 'name' => 'products.is_discountable'],
			['data' => 'is_active', 'title' => __('inventory_movements.is_active')],
			['data' => 'notes', 'title' => __('inventory_movements.notes')],
			['data' => 'updated_by', 'visible' => false, 'title' => __('inventory_movements.updated_by')],
			['data' => 'updated_at', 'visible' => false, 'title' => __('inventory_movements.updated_at')],
		];
		return array_merge($columns, $pColumns);
	}
}
