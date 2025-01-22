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

class ReportByMonthDataTable extends BlankDataTable
{
	use MonthTrait;
	public function __construct($year = null)
	{
		$this->routeResource = 'report_by_months';
		$this->year = $year;
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
			DB::raw('SUM(selling_rows.total_price) as total'),
			DB::raw('SUM((selling_rows.total_price * COALESCE(selling_rows.commission_percentage, 100) / 100)) as net_sales'),
			DB::raw('SUM(selling_rows.total_price - (selling_rows.total_price * COALESCE(selling_rows.commission_percentage, 100) / 100)) as commissions'),
		);
		$query->where('selling_rows.is_active', 1);
		if ($this->year != null) {
			$query->whereRaw('YEAR(selling_rows.created_at) = ?', [$this->year]);
		}
		$query->groupBy('year', 'month', 'monthname')
		->leftJoin('products', 'selling_rows.product_id', '=', 'products.id')
		->leftJoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
		->orderBy('year', 'desc')
  		->orderBy('month', 'desc')
		->orderBy('monthname', 'desc')->newQuery();
		return $query;
	}

	public function getActions($row)
	{
		$result = '';
		if(auth()->user()->hasPermissions($this->routeResource.".getByDay")) {
			$result .= '<a href="'.route($this->routeResource.".getByDay", [$this->year ?? $row->year, $row->month]).'">
				<button type="button" class="btn btn-default" title='.__('show').'>
					<i class="bx bxs-calendar text-primary actions_icon"></i>
				</button>
			</a>';
		}
		if(auth()->user()->hasPermissions($this->routeResource.".getMonthDetail")) {
			$result .= '<a href="'.route($this->routeResource.".getMonthDetail", [$this->year ?? $row->year, $row->month]).'">
				<button type="button" class="btn btn-default" title='.__('detail').'>
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
				$initialDate = str_replace('-', '', request('initial_date'));
				$finalDate = str_replace('-', '', request('final_date'));
				$query->whereRaw("YEAR(selling_rows.created_at)*100 + MONTH(selling_rows.created_at) >= ?", [$initialDate])
				->whereRaw("YEAR(selling_rows.created_at)*100 + MONTH(selling_rows.created_at) <= ?", [$finalDate]);
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
				['width' => '20%', 'targets' => 2, 'className' => 'text-end'],
				['width' => '20%', 'targets' => 3, 'className' => 'text-end'],
				['width' => '20%', 'targets' => 4, 'className' => 'text-end'],
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
			'footerCallback' => 'function() { footerCustomize([2,3,4], this.api(), [2,3,4]) }'

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
			['data' => 'total', 'title' => __('reports.total')],
			['data' => 'net_sales', 'title' => __('suppliers.commission_shop')],
			['data' => 'commissions', 'title' => __('suppliers.commission_supplier')],
		];
		return array_merge($columns, $pColumns);
	}
}
