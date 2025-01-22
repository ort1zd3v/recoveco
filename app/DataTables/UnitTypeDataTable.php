<?php

namespace App\DataTables;

use App\Models\UnitType;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UnitTypeDataTable extends BlankDataTable
{
	public function __construct()
	{
		$this->routeResource = 'unit_types';
	}
	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\Selling $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(UnitType $model)
	{
		return $model
		->newQuery();
	}

	public function dataTable($query)
	{
		$datatable = parent::dataTable($query);
		$datatable->editColumn('is_active', function ($row) {
			return $row->is_active ? "Sí" : "No";
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
			['data' => 'id', 'visible' => false],
			['data' => 'name', 'title' => __('unit_types.name')],
			['data' => 'description', 'title' => __('unit_types.description')],
			['data' => 'notes', 'title' => __('unit_types.notes')],
			['data' => 'is_active', 'title' => __('unit_types.is_active')],
			['data' => 'created_by', 'visible' => false],
			['data' => 'updated_by', 'visible' => false],
			['data' => 'created_at', 'visible' => false],
			['data' => 'updated_at', 'visible' => false],
		];
		return array_merge($columns, $pColumns);
	}
}
