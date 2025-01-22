<?php

namespace App\DataTables;

use App\Models\SellingRow;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;

class ReportByMonthDetailDataTable extends BlankDataTable
{
	public function __construct($year = null, $month = null)
	{
		$this->my_actions = false;
		$this->routeResource = 'report_by_months';
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
		$query = $model::whereRaw('YEAR(selling_rows.created_at) = ?', [$this->year])
		->whereRaw('MONTH(selling_rows.created_at) = ?', [$this->month])
		->selectRaw('
			products.name as product_id,
		 	SUM(selling_rows.amount) as total_amount, 
			SUM(selling_rows.total_price) as total_product_amount,
			CONCAT(suppliers.id, " - ", suppliers.name) as supplier_name,
			selling_rows.commission_percentage as commission_percentage,
			SUM(selling_rows.total_price) * COALESCE(selling_rows.commission_percentage, 1) / 100 as commission,
			SUM(selling_rows.total_price) - (SUM(selling_rows.total_price) * COALESCE(selling_rows.commission_percentage, 1) / 100) as commission2
		')
		->where('selling_rows.is_active', 1)
		->where('selling_rows.total_price', '<>', 0)
		->leftjoin('products', 'selling_rows.product_id', '=', 'products.id')
		->leftjoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
		->orderBy('total_product_amount', 'desc')
		->groupBy('products.name','product_id','products.supplier_id')
		->newQuery();
		
		return $query;
	}

	public function dataTable($query)
	{
		$datatable = parent::dataTable($query);
		$datatable->filter(function($query) {
			if(request('supplier_name') !== null){
				$query->where('suppliers.name','like',"%".request('supplier_name')."%")
				->orWhere('suppliers.id', 'like', '%'.request('supplier_name').'%');
			}

			if(request('product_name') !== null){
				$query->where('products.name','like',"%".request('product_name')."%");
			}

			$query->whereRaw('YEAR(selling_rows.created_at) = ?', [$this->year])
			->whereRaw('MONTH(selling_rows.created_at) = ?', [$this->month]);

		})->editColumn('total_product_amount', function ($row) {
			return "$".number_format($row->total_product_amount, 2, '.', ',');
		})->editColumn('commission', function ($row) {
			return "$".number_format($row->commission, 2, '.', ',');
		})->editColumn('commission2', function ($row) {
			return "$".number_format($row->commission2, 2, '.', ',');
		})->editColumn('commission_percentage', function ($row) {
			if ($row->supplier_name != null) {
				return ($row->commission_percentage)."%";
			}else {
				return ($row->commission_percentage);
			}

		});
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
			'responsive' => false,
			'stateSave' => false,
			'searching' => false,
			'columnDefs' => [
				['responsivePriority' => 1, 'targets' => 1],
				['width' => '20%', 'targets' => 0, 'className' => 'text-wrap'],
				['width' => '30%', 'targets' => 1, 'className' => 'text-wrap'],
				['width' => '10%', 'targets' => 2, 'className' => 'text-end'],
				['width' => '10%', 'targets' => 3, 'className' => 'text-end'],
				['width' => '10%', 'targets' => 4, 'className' => 'text-end'],
				['width' => '10%', 'targets' => 5, 'className' => 'text-end'],
				['width' => '10%', 'targets' => 6, 'className' => 'text-end']
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
			'footerCallback' => 'function() { footerCustomize([3,5,6], this.api(), [3,5,6]) }'
		];
	}

	public function html()
	{	
		return $this->builder()
			->parameters($this->getBuilderParameters())
			->setTableId($this->routeResource.'-table')
			->addTableClass('nowrap')
			->columns($this->getColumns())
			->minifiedAjax()
			->language(asset('js/datatables/datatables_Spanish.json'))
			//->orderBy(1)
			/*->buttons(
				Button::make('excel')->text('<i class="fa fa-file-excel"></i> '.__('Excel'))
				
			)*/;
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
			['data' => 'supplier_name', 'title' => __('products.supplier_id')],
			['data' => 'product_id', 'title' => __('reports.product_id')],
			['data' => 'total_amount', 'title' => __('reports.total_amount')],
			['data' => 'total_product_amount', 'title' => __('reports.total_product_amount')],
			['data' => 'commission_percentage', 'title' => __('suppliers.commission_percentage')],
			['data' => 'commission', 'title' => __('suppliers.commission_shop')],
			['data' => 'commission2', 'title' => __('suppliers.commission_supplier')],

		];
		return array_merge($columns, $pColumns);
	}
}
