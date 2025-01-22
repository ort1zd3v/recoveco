<?php

namespace App\DataTables;

use App\Models\SellingRow;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;

class ReportBySupplierDetailDataTable extends BlankDataTable
{
	public function __construct($supplier = null, $initial_date = null, $final_date = null)
	{
		$this->my_actions = false;
		$this->routeResource = 'report_by_suppliers';
		$this->supplier_id = $supplier->id;
		$this->initial_date = $initial_date;
		$this->final_date = $final_date;
	}
	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\SellingRow $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(SellingRow $model)
	{
		$query = $model->selectRaw(
			'
			 products.name as product_id,
			 SUM(selling_rows.amount) as total_amount,
			 SUM(selling_rows.total_price) as total_product_amount,
			 selling_rows.commission_percentage as commission_percentage,
			 SUM(selling_rows.total_price) * (COALESCE(selling_rows.commission_percentage, 1)/100) as commission,
			 SUM(selling_rows.total_price) - (SUM(selling_rows.total_price) * (COALESCE(selling_rows.commission_percentage, 1)/100)) as commission2
			'
		);
		if ($this->initial_date != 0) {
			$query->where('selling_rows.created_at','>=', $this->initial_date);
		}
		if ($this->final_date != 0) {
			$query->where('selling_rows.created_at','<=' ,$this->final_date." 23:59:59");
		}
		$query->where('products.supplier_id', $this->supplier_id)
		->where('selling_rows.is_active', 1)
		->where('selling_rows.total_price', '<>', 0)
		->leftjoin('products', 'selling_rows.product_id', '=', 'products.id')
		->leftjoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
		->orderBy('total_product_amount', 'desc')
		->groupBy('products.name','product_id','products.supplier_id', 'selling_rows.commission_percentage')
		->newQuery();

		return $query;
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

	public function dataTable($query)
	{

		$datatable = parent::dataTable($query);
		$datatable->filter(function($query) {
			if(request('initial_date') !== null && request('final_date') !== null){
				$query->where('selling_rows.created_at','>=' ,request('initial_date'))
					->where('selling_rows.created_at','<=' ,request('final_date')." 23:59:59");
			}
			if(request('product_name') !== null){
				$query->where('products.name','like', "%".request('product_name')."%");
			}
		})->editColumn('total_product_amount', function ($row) {
			return "$".number_format($row->total_product_amount, 2, '.', ',');
		})->editColumn('commission', function ($row) {
			return "$".number_format($row->commission, 2, '.', ',');
		})->editColumn('commission2', function ($row) {
			return "$".number_format($row->commission2, 2, '.', ',');
		})->editColumn('commission_percentage', function ($row) {
			return ($row->commission_percentage)."%";
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
				['width' => '50%', 'targets' => 0, 'className' => 'text-wrap'],
				['width' => '10%', 'targets' => 1, 'className' => 'text-end'],
				['width' => '10%', 'targets' => 2, 'className' => 'text-end'],
				['width' => '10%', 'targets' => 3, 'className' => 'text-end'],
				['width' => '10%', 'targets' => 4, 'className' => 'text-end'],
				['width' => '10%', 'targets' => 5, 'className' => 'text-end'],

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
			'footerCallback' => 'function() { footerCustomize([2,4,5], this.api(), [2,4,5]) }'
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
