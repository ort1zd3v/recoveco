<?php

namespace App\DataTables;

use App\Models\Selling;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;
use App\Traits\MonthTrait;

class ReportByTicketDataTable extends BlankDataTable
{
	use MonthTrait;

	public function __construct()
	{
		$this->routeResource = 'report_by_tickets';
	}
	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\Selling $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(Selling $model)
	{
		$query = $model->select(
			'sellings.id as selling_id',
			'sellings.total as total',
			'sellings.created_at as created_at',
			'sellings.is_active as is_active',
			'users.name as user',
			\DB::raw("(SELECT SUM(amount) FROM payments WHERE payments.selling_id = sellings.id AND payments.payment_type_id = 1) as cash_payment"),
			\DB::raw("(SELECT SUM(amount) FROM payments WHERE payments.selling_id = sellings.id AND payments.payment_type_id = 2) as credit_payment"),
			\DB::raw("(SELECT SUM(amount) FROM payments WHERE payments.selling_id = sellings.id AND payments.payment_type_id = 3) as deposit_payment"),
		)
		->leftJoin('users', 'sellings.created_by', 'users.id')
		->leftJoin('payments', 'sellings.id', 'payments.selling_id')
		->groupBy('sellings.id')
		->orderBy('created_at', 'desc')
		->newQuery();
		
		return $query;
	}

	public function getActions($row)
	{
		$result = '';
		if(auth()->user()->hasPermissions($this->routeResource.".getTicketDetail")) {
			$result .= '<a href="'.route($this->routeResource.".getTicketDetail", [$row->selling_id]).'">
				<button type="button" class="btn btn-default" title='.__('show').'>
					<i class="fa fa-eye text-primary actions_icon"></i>
				</button>
			</a>';
		}
		if(auth()->user()->hasPermissions($this->routeResource.".cancelSelling")) {
			$result .= '
				<button type="button" class="btn btn-default" title="'.__('delete').'" onclick="showCancelSelling('.$row->selling_id.')">
					<i class="bx bx-x-circle text-danger font-size-16"></i>
				</button>';
		}
		$result .= '
				<button type="button" class="btn btn-default" title="'.__('print').'" onclick="getTicket('.$row->selling_id.')">
					<i class="bx bx-printer text-secondary font-size-16"></i>
				</button>';
		return $result;
	}

	public function dataTable($query)
	{
		$datatable = parent::dataTable($query);
		$datatable->filter(function($query) {
			if(request('initial_date') !== null && request('final_date') !== null){
				$query->where('sellings.created_at','>=' ,request('initial_date'))
					->where('sellings.created_at','<=' ,request('final_date')." 23:59:59");
			}
			if(request('selling_id') !== null){
				$query->where('sellings.id', request('selling_id'));
			}
			if(request('is_active') == "2"){
				$query->orWhere('sellings.is_active', 0);
			}
			if(request('is_active') == "1"){
				$query->orWhere('sellings.is_active', 1);
			}
			if(request('payment_types') != 0){
				$query->where('payments.payment_type_id', request('payment_types'));
			}
			if(request('created_by') != 0){
				$query->where('sellings.created_by', request('created_by'));
			}
		})->editColumn('created_at', function ($row) {
			return date("d/m/Y H:i:s", strtotime($row->created_at));
		})->editColumn('total', function ($row) {
			return "$".number_format($row->total, 2, '.', ',');
		})->editColumn('cash_payment', function ($row) {
			return "$".number_format($row->cash_payment, 2, '.', ',');
		})->editColumn('credit_payment', function ($row) {
			return "$".number_format($row->credit_payment, 2, '.', ',');
		})->editColumn('deposit_payment', function ($row) {
			return "$".number_format($row->deposit_payment, 2, '.', ',');
		})->editColumn('is_active', function ($row) {
			return $row->is_active == 0 ? "Cancelado" : "Activo";
		})->rawColumns(["action"]);
		return $datatable;
	}

	public function getBuilderParameters()
	{	
		return [
			'pageLength' => 50,
			'lengthMenu'=> [
				[50,100,200,500,1000, -1 ],
				[50, 100,200,500,1000, "Todos" ]
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
				['className' => "text-end", 'targets' => 4],
				['className' => "text-end", 'targets' => 5],
				['className' => "text-end", 'targets' => 6],

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
				var dataTable = this.api();
				if ((!dataTable.settings()[0].oFeatures.bFilter || !dataTable.settings()[0].oFeatures.bFiltering)) {
					var exportButton = $('.buttons-excel');
					exportButton.prop('disabled', false);
				}
				customizeDatatable(false);
			}",
			'initComplete' => 'function(settings, json) {
				$(".dataTables_length").find("select").on("change", function() {
					var selectedOption = $(this).val();
					var exportButton = $(".buttons-excel");
					exportButton.prop("disabled", true);
				});
			}',
			'footerCallback' => 'function() { footerCustomize([1,4,5,6], this.api(), [0,3,4,5]) }'

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
			['data' => 'selling_id', 'title' => __('report_by_tickets.selling_id')],
			['data' => 'total', 'title' => __('reports.total')],
			['data' => 'created_at', 'title' => __('reports.created_at')],
			['data' => 'user', 'title' => __('report_by_tickets.created_by')],
			['data' => 'cash_payment', 'title' => '<img style="margin-bottom:10px" src="'.asset('images/cash.png').'" height=30px>'],
			['data' => 'credit_payment', 'title' => '<img style="margin-bottom:10px" src="'.asset('images/credit-card.png').'" height=30px>'],
			['data' => 'deposit_payment', 'title' => '<img src="'.asset('images/gift-card.png').'" height=50px>'],
			['data' => 'is_active', 'title' => __('report_by_tickets.status')],
		];
		return array_merge($columns, $pColumns);
	}
}
