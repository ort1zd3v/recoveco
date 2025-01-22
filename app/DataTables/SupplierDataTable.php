<?php

namespace App\DataTables;

use App\Models\Supplier;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SupplierDataTable extends BlankDataTable
{
	public function __construct()
	{
		$this->routeResource = 'suppliers';
	}
	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\Selling $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(Supplier $model)
	{
		return $model
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
					[15,30,45, -1],
					[15,30,45, 'TODOS'],
				],
				'columnDefs' => [
					['responsivePriority' => 1, 'targets' => 0],
					['width' => '30%', 'targets' => 1, 'className' => 'text-wrap'],
					['width' => '30%', 'targets' => 2, 'className' => 'text-wrap'],
					['width' => '10%', 'targets' => 3, 'className' => 'text-center'],
					['width' => '10%', 'targets' => 4, 'className' => 'text-end'],
	
				],
			]
		);

		return $result;
	}

	public function dataTable($query)
	{

		$datatable = parent::dataTable($query);
		$datatable->editColumn('is_active', function ($row) {
			return $row->is_active ? "Sí" : "No";
		})->editColumn('commission_percentage', function ($row) {
			return $row->commission_percentage."%";
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
			['data' => 'id', 'title' => __('suppliers.id')],
			['data' => 'name', 'title' => __('suppliers.name')],
			['data' => 'description', 'title' => __('suppliers.description')],
			['data' => 'commission_percentage', 'title' => __('suppliers.commission_percentage')],
			['data' => 'is_active', 'title' => __('suppliers.is_active')],
			['data' => 'notes', 'title' => __('suppliers.notes')],
			['data' => 'created_by', 'visible' => false, 'title' => __('suppliers.created_by')],
			['data' => 'updated_by', 'visible' => false, 'title' => __('suppliers.updated_by')],
			['data' => 'created_at', 'visible' => false, 'title' => __('suppliers.created_at')],
			['data' => 'updated_at', 'visible' => false, 'title' => __('suppliers.updated_at')],
		];
		return array_merge($columns, $pColumns);
	}
}
