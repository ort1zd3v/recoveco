<?php

namespace App\DataTables;

use App\Models\SellingRow;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;
use DateTime;

class ReportBySellingDataTable extends BlankDataTable
{

	public function __construct()
	{
		$this->routeResource = 'report_by_sellings';
		$this->my_actions = false;

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
			'sellings.id as selling_id',
			DB::raw('CONCAT(suppliers.id, " - ", suppliers.name) as supplier_name'),
			'products.name as product_name',
			'selling_rows.amount as amount',
			'selling_rows.total_price as total_price',
			'users.name as created_by',
			'selling_rows.created_at as created_at',
		)
		->leftJoin('sellings', 'selling_rows.selling_id', 'sellings.id')
		->leftJoin('products', 'selling_rows.product_id', 'products.id')
		->leftJoin('suppliers', 'products.supplier_id', 'suppliers.id')
		->leftJoin('users', 'selling_rows.created_by', 'users.id')

		->where('selling_rows.is_active', 1)
		->orderBy('sellings.id', 'desc')
		->newQuery();

		return $query;
	}

	public function dataTable($query)
	{
		$datatable = parent::dataTable($query);
		$datatable->filter(function($query) {
			if(request('supplier_name') !== null){
				$query->where('suppliers.name','like', "%".request('supplier_name')."%")
				->orWhere('suppliers.id','like', "%".request('supplier_name')."%");
			}
			if(request('product_name') !== null){
				$query->where('products.name','like', "%".request('product_name')."%");
			}
			if(request('selling_id') !== null){
				$query->where('sellings.id', request('selling_id'));
			}
			if(request('initial_date') !== null && request('final_date') !== null){
				$query->where('selling_rows.created_at','>=' ,request('initial_date'))
					->where('selling_rows.created_at','<=' ,request('final_date')." 23:59:59");
			}else{
				$todayInit = new DateTime();
				$todayFinal = new DateTime();
				$todayInit->setTime(0, 0, 0)->format('Y-m-d H:i:s');
				$todayFinal->setTime(23, 59, 59)->format('Y-m-d H:i:s');
				
				$query->where('selling_rows.created_at','>=' , $todayInit)
					->where('selling_rows.created_at','<=' ,$todayFinal);
			}
		})->editColumn('created_at', function ($row) {
			return date("d/m/Y H:i:s", strtotime($row->created_at));
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
				['targets' => 1, 'className' => 'text-wrap'],
				['targets' => 2, 'className' => 'text-wrap'],
				['targets' => 4, 'className' => 'text-end'],

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
			['data' => 'selling_id', 'title' => __('report_by_sellings.selling_id')],
			['data' => 'supplier_name', 'title' => __('report_by_sellings.supplier_name')],
			['data' => 'product_name', 'title' =>  __('report_by_sellings.product_name')],
			['data' => 'amount', 'title' => __('report_by_sellings.amount')],
			['data' => 'total_price', 'title' => __('report_by_sellings.total_price')],
			['data' => 'created_by', 'title' => __('report_by_sellings.created_by')],
			['data' => 'created_at', 'title' => __('report_by_sellings.created_at')],
		];
		return array_merge($columns, $pColumns);
	}
}
