<?php

namespace App\DataTables;

use App\Models\SellingRow;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;

class ReportByTicketDetailDataTable extends BlankDataTable
{
	public function __construct($selling_id)
	{
		$this->my_actions = false;
		$this->routeResource = 'report_by_tickets';
		$this->selling_id = $selling_id;
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
			DB::raw('CONCAT(suppliers.id, " - ", suppliers.name) as supplier_name'),
			'products.name as product_name',
			'selling_rows.amount as amount',
			'selling_rows.unit_price as unit_price',
			'selling_rows.total_price as total_price',
		);
		$query->where('selling_rows.selling_id', $this->selling_id)
		->where('selling_rows.total_price', '<>', 0)
		->leftjoin('products', 'selling_rows.product_id', '=', 'products.id')
		->leftjoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
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
		$datatable->editColumn('unit_price', function ($row) {
			return "$".number_format($row->unit_price, 2, '.', ',');
		})->editColumn('total_price', function ($row) {
			return "$".number_format($row->total_price, 2, '.', ',');
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
				['width' => '50%', 'targets' => 1, 'className' => 'text-wrap'],
				['width' => '10%', 'targets' => 2, 'className' => 'text-end'],
				['width' => '10%', 'targets' => 3, 'className' => 'text-end'],
				['width' => '10%', 'targets' => 4, 'className' => 'text-end'],
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
			'footerCallback' => 'function() { footerCustomize([4], this.api(), [4]) }'
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
			['data' => 'supplier_name', 'title' => __('reports.supplier_name')],
			['data' => 'product_name', 'title' => __('products.name')],
			['data' => 'amount', 'title' => __('products.amount')],
			['data' => 'unit_price', 'title' => __('products.price_base')],
			['data' => 'total_price', 'title' => __('reports.total_price')],

		];
		return array_merge($columns, $pColumns);
	}
}
