<?php

namespace App\DataTables;

use App\Models\Inventory;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;

class InventoryDataTable extends BlankDataTable
{
	public function __construct()
	{
		$this->routeResource = 'inventories';
	}
	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\Selling $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(Inventory $model)
	{
		return $model->select(
			'inventories.*',
			'products.name as product_name',
			DB::raw('CONCAT(suppliers.id, " - ", suppliers.name) as supplier_name'),

		)
		->leftjoin('products', 'inventories.product_id', '=', 'products.id')
		->leftjoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
		->orderBy('product_name', 'asc')
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
					[30,50,100, 200, 500, 1000, -1],
					[30,50,100, 200, 500, 1000, "Todos"],
				],
				'columnDefs' => [
					['responsivePriority' => 1, 'targets' => 0],
					['width' => '50%', 'targets' => 2, 'className' => 'text-wrap'],
					['width' => '50%', 'targets' => 3, 'className' => 'text-wrap'],
				],
			]
		);

		return $result;
	}

	public function dataTable($query)
	{
		$datatable = parent::dataTable($query);
		$datatable->filter(function($query) {
			if (request()->supplier_name != null){
				$query->where('suppliers.name', 'LIKE', '%'.request()->supplier_name.'%')
					   ->orWhere('suppliers.id', 'LIKE', '%'.request()->supplier_name.'%');
			}

			if (request()->product_name != null){
				$query->where('products.name', 'LIKE', '%'.request()->product_name.'%');
			}
			
		}, true)->editColumn('supplier_name', function ($row) {
			return $row->supplier_name == null ? 'N/A' : $row->supplier_name;
		})->rawColumns(["action"]);
		
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
			['data' => 'id', 'visible' => false, 'title' => __('inventories.id')],
			['data' => 'supplier_name', 'title' => __('inventories.supplier_name'), 'name' => 'suppliers.name'],
			['data' => 'product_name', 'title' => __('inventories.product_name'), 'name' => 'products.name'],
			['data' => 'amount', 'title' => __('inventories.amount')],
			['data' => 'notes', 'title' => __('inventories.notes')],
			['data' => 'created_by', 'visible' => false, 'title' => __('inventories.created_by')],
			['data' => 'updated_by', 'visible' => false, 'title' => __('inventories.updated_by')],
			['data' => 'created_at', 'visible' => false, 'title' => __('inventories.created_at')],
			['data' => 'updated_at', 'visible' => false, 'title' => __('inventories.updated_at')],
		];
		return array_merge($columns, $pColumns);
	}
}
