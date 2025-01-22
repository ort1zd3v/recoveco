<?php

namespace App\DataTables;

use App\Models\SellingRow;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;
use App\Traits\MonthTrait;

class ReportByDayDataTable extends BlankDataTable
{
	use MonthTrait;

	public function __construct($year = null, $month = null)
	{
		$this->routeResource = 'report_by_days';
		$this->year = $year;
		$this->month = $month;
	}
	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\SellingRow $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(SellingRow $model)
	{
		$query = $model->select(
			DB::raw('YEAR(selling_rows.created_at) as year'),
			DB::raw('MONTH(selling_rows.created_at) as month'),
			DB::raw("DATE_FORMAT(selling_rows.created_at, '%M') as monthname"),
			DB::raw('DAY(selling_rows.created_at) as day'),
			DB::raw('SUM(selling_rows.total_price) as total'),
			DB::raw('SUM((selling_rows.total_price * COALESCE(selling_rows.commission_percentage, 100) / 100)) as net_sales'),
			DB::raw('SUM(selling_rows.total_price - (selling_rows.total_price * COALESCE(selling_rows.commission_percentage, 100) / 100)) as commissions'),
		);
		$query->where('selling_rows.is_active', 1);
		if ($this->year != null) {
			$query->whereRaw('YEAR(selling_rows.created_at) = ?', [$this->year]);
		}
		if ($this->month != null) {
			$query->whereRaw('MONTH(selling_rows.created_at) = ?', [$this->month]);
		}
		$query->where('selling_rows.is_active', 1);

		$query->groupBy('year','month','day', 'monthname')
		->leftJoin('products', 'selling_rows.product_id', '=', 'products.id')
		->leftJoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
		->orderBy('year', 'desc')
		->orderBy('month', 'desc')
		->orderBy('day', 'desc')
	  	->orderBy('monthname', 'desc')->newQuery();
		return $query;
	}

	public function getActions($row)
	{
		$result = '';
		if(auth()->user()->hasPermissions($this->routeResource.".getDayDetail")) {
			$result .= '<a href="'.route($this->routeResource.".getDayDetail", [$row->year, $row->month, $row->day]).'">
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
				$query->where('selling_rows.created_at','>=' ,request('initial_date'))
					->where('selling_rows.created_at','<=' ,request('final_date')." 23:59:59");
			}

		})->editColumn('monthname', function ($row) {
			return $this->getNameOfMonth($row->month);
		})->editColumn('total', function ($row) {
			return "$".number_format($row->total, 2, '.', ',');
		})->editColumn('net_sales', function ($row) {
			return "$".number_format($row->net_sales, 2, '.', ',');
		})->editColumn('commissions', function ($row) {
			return "$".number_format($row->commissions, 2, '.', ',');
		})->rawColumns(["action"]);
			
		return $datatable;
	}

	public function getBuilderParameters()
	{	
		return [
			'pageLength' => 15,
			'lengthMenu'=> [
				[15,30,45, -1 ],
				[15, 30, 45, "Todos" ]
			],
			'dom' => 'lfBrtip',
			'serverSide' => true,
			'processing' => true,
			'responsive' => true,
			'stateSave' => false,
			'searching' => false,
			'columnDefs' => [
				['responsivePriority' => 1, 'targets' => 1],
				['width' => '20%', 'targets' => 3, 'className' => 'text-end'],
				['width' => '20%', 'targets' => 4, 'className' => 'text-end'],
				['width' => '20%', 'targets' => 5, 'className' => 'text-end'],

			],
			'buttons' => [
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
							'columns' => ':visible',
							'modifier' => [
								'page' => 'all',
							],
						]
					],
				],
			],
			'footerCallback' => 'function() { footerCustomize([3,4,5], this.api(), [3,4,5]) }',
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
			['data' => 'year', 'title' => __('reports.year')],
			['data' => 'monthname', 'title' => __('reports.monthname')],
			['data' => 'day', 'title' => __('reports.day')],
			['data' => 'total', 'title' => __('reports.total')],
			['data' => 'net_sales', 'title' => __('suppliers.commission_shop')],
			['data' => 'commissions', 'title' => __('suppliers.commission_supplier')],

		];
		return array_merge($columns, $pColumns);
	}
}
