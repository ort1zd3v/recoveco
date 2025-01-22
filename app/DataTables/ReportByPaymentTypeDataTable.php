<?php

namespace App\DataTables;

use App\Models\Payment;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;

class ReportByPaymentTypeDataTable extends BlankDataTable
{

	public function __construct()
	{
		$this->routeResource = 'report_by_payment_types';
		$this->my_actions = false;

	}
	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\Selling $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(Payment $model)
	{
		$query = $model->select(
			DB::raw('DATE(created_at) as fecha'),
			DB::raw('SUM(CASE WHEN payment_type_id = 1 THEN amount ELSE 0 END) as total_cash'),
			DB::raw('SUM(CASE WHEN payment_type_id = 2 THEN amount ELSE 0 END) as total_credit'),
			DB::raw('SUM(CASE WHEN payment_type_id = 3 THEN amount ELSE 0 END) as total_deposit')

		)
		->where('payments.is_active', 1)
		->orderBy('created_at', 'desc')
		->groupBy(DB::raw('DATE(created_at)'))
		->newQuery();

		return $query;
	}

	public function dataTable($query)
	{
		$datatable = parent::dataTable($query);
		$datatable->filter(function($query) {
			if(request('initial_date') !== null && request('final_date') !== null){
				$query->where('payments.created_at','>=' ,request('initial_date'))
					->where('payments.created_at','<=' ,request('final_date')." 23:59:59");
			}
		})->editColumn('fecha', function ($row) {
			return date_format(date_create($row->fecha), 'd/m/Y');
		})->editColumn('total_cash', function ($row) {
			return "$".number_format($row->total_cash, 2, '.', ',');
		})->editColumn('total_credit', function ($row) {
			return "$".number_format($row->total_credit, 2, '.', ',');
		})->editColumn('total_deposit', function ($row) {
			return "$".number_format($row->total_deposit, 2, '.', ',');
		});
		return $datatable;
	}


	public function getBuilderParameters()
	{	
		return [
			'pageLength' => 15,
			'lengthMenu'=> [
				[15,30,50,100,500, -1 ],
				[15, 30,50,100,500, "Todos" ]
			],
			'dom' => 'lfBrtip',
			'serverSide' => true,
			'processing' => true,
			'responsive' => true,
			'stateSave' => false,
			'searching' => false,
			'columnDefs' => [
				['responsivePriority' => 1, 'targets' => 0],
				['className' => "text-end", 'targets' => 1],
				['className' => "text-end", 'targets' => 2],
				['className' => "text-end", 'targets' => 3],

			],
			'buttons' => [
				['extend' => 'colvis', 'text' => 'Mostrar/Ocultar Columnas', 'className' => 'btn btn-primary'],
				'buttons' => [
					[
						'extend' => 'colvis',
						'text' => 'Mostrar/Ocultar Columnas',
						'className' => 'btn btn-primary',
					],
					[
						'extend' => 'excel',
						'text' => '<i class="fas fa-file-excel"></i> Exportar a excel',
						'className' => 'btn btn-success',
						'exportOptions' => [
							'columns' => ':visible'
						]
					],
				],
			],
			'drawCallback' => "function() {
				customizeDatatable(false);
			}",
			'footerCallback' => 'function() { footerCustomize([1,2,3], this.api(), [1,2,3]) }'

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
			['data' => 'fecha', 'title' => __('report_by_payment_types.created_at')],
			['data' => 'total_cash', 'title' => __('report_by_payment_types.total_cash')],
			['data' => 'total_credit', 'title' =>  __('report_by_payment_types.total_credit')],
			['data' => 'total_deposit', 'title' => __('report_by_payment_types.total_deposit')],

		];
		return array_merge($columns, $pColumns);
	}
}
