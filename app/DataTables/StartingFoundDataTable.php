<?php

namespace App\DataTables;

use App\Models\StartingFound;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class StartingFoundDataTable extends BlankDataTable
{
	public function __construct()
	{
		$this->routeResource = 'starting_founds';
	}
	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\Selling $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(StartingFound $model)
	{
		return $model->select(
			'starting_founds.*',
			'initiator.name as initial_user_name',
			'finalizer.name as final_user_name'
		)
		->leftJoin('users as initiator', 'starting_founds.initial_user_id', '=', 'initiator.id')
		->leftJoin('users as finalizer', 'starting_founds.final_user_id', '=', 'finalizer.id')
		->orderBy('starting_founds.initial_date', 'desc')
		->newQuery();

		
	}

	public function getActions($row)
	{
		$result = '';
		if(auth()->user()->hasPermissions($this->routeResource.".show")) {
			$result .= '<a href="'.route($this->routeResource.".show", $row->id).'">
				<button type="button" class="btn btn-default" title='.__('show').'>
					<i class="fa fa-eye text-primary actions_icon"></i>
				</button>
			</a>';
		}
		return $result;
	}

	public function dataTable($query)
	{

		$datatable = parent::dataTable($query);
		
		$datatable->filter(function($query) {
			if(request('initial_date') !== null && request('final_date') !== null){
				$query->where('initial_date','>=' ,request('initial_date'))
					->where('initial_date','<=' ,request('final_date')." 23:59:59");
			}
			if (request('search.value') != '') {
				$query->orWhere('initiator.name', 'LIKE', '%'.request('search.value').'%');
			}

		}, true)->editColumn('is_active', function ($row) {
			return $row->is_active ? "Sí" : "No";
		})->editColumn('initial_date', function ($row) {
			return date("d/m/Y H:i:s", strtotime($row->created_at));
		})->editColumn('amount', function ($row) {
			return "$".number_format($row->amount, 2, '.', ',');
		})->editColumn('final_date', function ($row) {
			if ($row->final_date) {
				return date("d/m/Y H:i:s", strtotime($row->final_date));
			}
		})->rawColumns(["action"]);
			
		return $datatable;
	}

	public function getBuilderParameters()
	{	
		return [
			'pageLength' => 15,
			// 'lengthMenu'=> [
			// 	[15,30,45, -1 ],
			// 	[15, 30, 45, "Todos" ]
			// ],
			'dom' => 'fBrtip',
			'serverSide' => true,
			'processing' => true,
			'responsive' => true,
			'stateSave' => false,
			'searching' => true,
			'columnDefs' => [
				['responsivePriority' => 1, 'targets' => 1],
				['targets' => 5, 'className' => "text-end"],
			],
			'buttons' => [
				['extend' => 'colvis', 'text' => 'Mostrar/Ocultar Columnas', 'className' => 'btn btn-primary']
			],
			'drawCallback' => 'function() { customizeDatatable(false) }',

		];
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
			['data' => 'id', 'visible' => false, 'title' => __('starting_founds.id')],
			['data' => 'initial_date', 'title' => __('starting_founds.initial_date')],
			['data' => 'final_date', 'title' => __('starting_founds.final_date')],
			['data' => 'initial_user_name', 'title' => __('starting_founds.initial_user_id'), 'name' => "starting_founds.initial_user_id"],
			['data' => 'final_user_name', 'title' => __('starting_founds.final_user_id'), 'name' => "starting_founds.final_user_id"],

			['data' => 'amount', 'title' => __('starting_founds.amount')],
			['data' => 'notes', 'title' => __('starting_founds.notes')],
			['data' => 'is_active', 'title' => __('starting_founds.is_active')],
			['data' => 'created_by', 'visible' => false, 'title' => __('starting_founds.created_by')],
			['data' => 'updated_by', 'visible' => false, 'title' => __('starting_founds.updated_by')],
			['data' => 'created_at', 'visible' => false, 'title' => __('starting_founds.created_at')],
			['data' => 'updated_at', 'visible' => false, 'title' => __('starting_founds.updated_at')],
		];
		return array_merge($columns, $pColumns);
	}
}
