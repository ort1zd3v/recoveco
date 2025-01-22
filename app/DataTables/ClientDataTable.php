<?php

namespace App\DataTables;

use App\Models\Client;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ClientDataTable extends BlankDataTable
{
	public function __construct()
	{
		$this->routeResource = 'clients';
	}
	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\Selling $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(Client $model)
	{
		return $model->select(
			'clients.*',
			'branches.name as branch_id'
		)
		->leftjoin('branches', 'clients.branch_id', '=', 'branches.id')
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
			['data' => 'id', 'visible' => false, 'title' => __('clients.id')],
			['data' => 'name', 'title' => __('clients.name')],
			['data' => 'client_number', 'title' => __('clients.client_number')],
			['data' => 'branch_id', 'title' => __('clients.branch_id'), 'name' => 'branches.name'],
			// ['data' => 'notes', 'title' => __('clients.notes')],
			// ['data' => 'is_active', 'title' => __('clients.is_active')],
			['data' => 'created_by', 'visible' => false, 'title' => __('clients.created_by')],
			['data' => 'updated_by', 'visible' => false, 'title' => __('clients.updated_by')],
			['data' => 'created_at', 'visible' => false, 'title' => __('clients.created_at')],
			['data' => 'updated_at', 'visible' => false, 'title' => __('clients.updated_at')],
		];
		return array_merge($columns, $pColumns);
	}

	public function getBuilderParameters()
	{	
		return [
			'pageLength' => 15,
			'dom' => 'fBrtip',
			'serverSide' => true,
			'processing' => true,
			'responsive' => true,
			'stateSave' => true,
			'buttons' => [
				'colvis'
			],
			'columnDefs' => [
				['responsivePriority' => 1, 'targets' => 1] 
			],
			'buttons' => [
				['extend' => 'colvis', 'text' => 'Mostrar/Ocultar Columnas', 'className' => 'btn btn-primary']
			],
			'drawCallback' => 'function() { customizeDatatable(false) }'
		];
	}

	public function getActions($row)
	{
		$result = '';

		if(auth()->user()->hasPermissions($this->routeResource.".edit")) {
			$result .= '
				<a class="btn btn-default" title="'.__('edit').'" href="'.route($this->routeResource.".edit", $row->id).'">
					<i class="mdi mdi-pencil icon-edit font-size-18"></i>
				</a>';
		}

		if(auth()->user()->hasPermissions($this->routeResource.".destroy")) {
			$result .= '
				<a class="btn btn-default" title="'.__('delete').'" onclick="showDeleteModal(\''.$this->routeResource.'\', '.$row->id.')">
					<i class="mdi mdi-delete icon-delete font-size-18"></i>
				</a>';
		}

		return $result;
	}
}
