<?php

namespace App\DataTables;

use App\Models\Category;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CategoryDataTable extends BlankDataTable
{
	public function __construct()
	{
		$this->routeResource = 'categories';
	}
	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\Selling $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(Category $model)
	{
		return $model->select(
			'categories.*',
			'categories2.name as category2_id'
		)
		->leftjoin('categories as categories2', 'categories2.id', '=', 'categories.category_id')
		->orderBy('categories.print_order', 'asc')
		->newQuery();
	}

	public function dataTable($query)
	{
		$datatable = parent::dataTable($query);
		$datatable->editColumn('is_active', function ($row) {
			return $row->is_active ? "Sí" : "No";
		})->editColumn('is_visible', function ($row) {
			return $row->is_visible ? "Sí" : "No";
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
			['data' => 'category_id', 'title' => __('categories.category_id'), 'name' => 'categories2.name'],
			['data' => 'name', 'title' => __('categories.name')],
			['data' => 'description', 'title' => __('categories.description')],
			['data' => 'print_order', 'title' => __('categories.print_order')],
			['data' => 'is_visible', 'title' => __('categories.is_visible')],
			['data' => 'is_active', 'title' => __('categories.is_active')],
			['data' => 'notes', 'title' => __('categories.notes')],
			['data' => 'created_by', 'visible' => false],
			['data' => 'updated_by', 'visible' => false],
			['data' => 'created_at', 'visible' => false],
			['data' => 'updated_at', 'visible' => false],
		];
		return array_merge($columns, $pColumns);
	}
}
