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

class ReportBySupplierDataTable extends BlankDataTable
{
	use MonthTrait;

	public function __construct()
	{
		$this->routeResource = 'report_by_suppliers';
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
			DB::raw('suppliers.id as supplier_id'),
			DB::raw('CONCAT(suppliers.id, " - ", suppliers.name) as supplier_name'),
			DB::raw('SUM(selling_rows.total_price) as total'),
			DB::raw('SUM((selling_rows.total_price * COALESCE(selling_rows.commission_percentage, 100) / 100)) as net_sales'),
			DB::raw('SUM(selling_rows.total_price - (selling_rows.total_price * COALESCE(selling_rows.commission_percentage, 100) / 100)) as commissions'),
		);
		$query->where('selling_rows.is_active', 1)
			->where('suppliers.name', '<>', 'null')
			->where('suppliers.is_active', 1)
			->leftJoin('products', 'selling_rows.product_id', '=', 'products.id')
			->leftJoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
			->groupBy('suppliers.id')
			->newQuery();
		return $query;
	}

	public function getActions($row)
	{
		$result = '';
		if(auth()->user()->hasPermissions($this->routeResource.".getSupplierDetail")) {
			$result .= '<a href="#" onclick="generateUrlAndRedirect(event, '.$row->supplier_id.')">
							<button type="button" class="btn btn-default" title="' . __('show') . '">
								<i class="fa fa-eye text-primary actions_icon"></i>
							</button>
						</a>';

			$result .= '<script>
				function generateUrlAndRedirect(event, supplierId = null) {
					event.preventDefault(); // Evitar el comportamiento de redireccionamiento predeterminado
			
					// Obtener los valores de los campos de entrada utilizando JavaScript
					let initial_date = document.getElementById("initial_date").value;
					let final_date = document.getElementById("final_date").value;
					let supplier_id = supplierId;

					if (initial_date == "") {
						initial_date = 0
					}

					if (final_date == "") {
						final_date = 0
					}
			
					// Generar la URL utilizando los valores de los campos de entrada
					let url = "' . route($this->routeResource . '.getSupplierDetail', ["supplier_id", "initial_date", "final_date"]) . '"
						.replace("initial_date", initial_date)
						.replace("final_date", final_date)
						.replace("supplier_id", supplier_id);

					// Redirigir al usuario a la URL generada
					window.location.href = url;
				}
			</script>';

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
			if(request('supplier_name') !== null){
				$query->where('suppliers.name','like', "%".request('supplier_name')."%")
				->orWhere('suppliers.id','like', "%".request('supplier_name')."%");
			}
			if(request('is_active') == "1"){
				$query->orWhere('suppliers.is_active', 0);
			}
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
			'footerCallback' => 'function() { footerCustomize([2,3,4], this.api(), [1,2,3]) }'

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
			['data' => 'supplier_id', 'title' => __('products.supplier_id'), 'visible' => false],
			['data' => 'supplier_name', 'title' => __('products.supplier_id')],
			['data' => 'total', 'title' => __('reports.total')],
			['data' => 'net_sales', 'title' => __('suppliers.commission_shop')],
			['data' => 'commissions', 'title' => __('suppliers.commission_supplier')],

		];
		return array_merge($columns, $pColumns);
	}
}
