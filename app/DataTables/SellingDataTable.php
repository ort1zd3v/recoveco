<?php

namespace App\DataTables;

use App\Models\Selling;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SellingDataTable extends BlankDataTable
{
	public function __construct()
	{
		$this->routeResource = 'sellings';
	}
	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\Selling $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(Selling $model)
	{
		return $model->select(
			'sellings.*',
			'clients.name as client_id'
		)
		->leftjoin('clients', 'sellings.client_id', '=', 'clients.id')
		->newQuery();
	}

	public function getActions($row)
	{
		return null;
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
			['data' => 'id', 'visible' => false, 'title' => __('sellings.id')],
			['data' => 'client_id', 'title' => __('sellings.client_id'), 'name' => 'clients.name'],
			['data' => 'subtotal', 'title' => __('sellings.subtotal')],
			['data' => 'iva', 'title' => __('sellings.iva')],
			['data' => 'total', 'title' => __('sellings.total')],
			['data' => 'notes', 'title' => __('sellings.notes')],
			['data' => 'is_active', 'title' => __('sellings.is_active')],
			['data' => 'created_by', 'visible' => false, 'title' => __('sellings.created_by')],
			['data' => 'updated_by', 'visible' => false, 'title' => __('sellings.updated_by')],
			['data' => 'created_at', 'visible' => false, 'title' => __('sellings.created_at')],
			['data' => 'updated_at', 'visible' => false, 'title' => __('sellings.updated_at')],
		];
		return array_merge($columns, $pColumns);
	}
}
