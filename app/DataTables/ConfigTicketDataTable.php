<?php

namespace App\DataTables;

use App\Models\ConfigTicket;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ConfigTicketDataTable extends BlankDataTable
{
	public function __construct()
	{
		$this->routeResource = 'config_tickets';
	}
	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\Selling $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(ConfigTicket $model)
	{
		return $model
		->newQuery();
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
			['data' => 'id', 'visible' => false, 'title' => __('config_tickets.id')],
			['data' => 'url_logo', 'title' => __('config_tickets.url_logo')],
			['data' => 'header', 'title' => __('config_tickets.header')],
			['data' => 'footer', 'title' => __('config_tickets.footer')],
			['data' => 'footer2', 'title' => __('config_tickets.footer2')],
			['data' => 'notes', 'title' => __('config_tickets.notes')],
			['data' => 'is_active', 'title' => __('config_tickets.is_active')],
			['data' => 'created_by', 'visible' => false, 'title' => __('config_tickets.created_by')],
			['data' => 'updated_by', 'visible' => false, 'title' => __('config_tickets.updated_by')],
			['data' => 'created_at', 'visible' => false, 'title' => __('config_tickets.created_at')],
			['data' => 'updated_at', 'visible' => false, 'title' => __('config_tickets.updated_at')],
		];
		return array_merge($columns, $pColumns);
	}
}
