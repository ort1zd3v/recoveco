<?php

namespace App\DataTables;

use App\Models\Product;
use App\Models\Supplier;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends BlankDataTable
{
	private $type;
	public function __construct($type = null)
	{
		$this->routeResource = 'products';
		$this->type = $type;
		if ($type == 'pos') {
			$this->my_actions = false;
		}
	}

	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\Selling $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(Product $model)
	{
		if ($this->type = "pos") {
			$result = $model->select(
				'products.*',
				'categories.name as category_id',
				'unit_types.name as unit_type_id',
				'suppliers.name as supplier_name',
				'inventories.amount as amount',
	
			)
			->where('products.is_active', 1)
			->leftjoin('categories', 'products.category_id', '=', 'categories.id')
			->leftjoin('unit_types', 'products.unit_type_id', '=', 'unit_types.id')
			->leftjoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
			->leftjoin('inventories', 'products.id', '=', 'inventories.product_id')
			->newQuery();
		}

		$result = $model->select(
			'products.*',
			'categories.name as category_id',
			'unit_types.name as unit_type_id',
			'suppliers.id as supplier_id',
			'suppliers.name as supplier_name',
			'inventories.amount as amount',

		)
		->leftjoin('categories', 'products.category_id', '=', 'categories.id')
		->leftjoin('unit_types', 'products.unit_type_id', '=', 'unit_types.id')
		->leftjoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
		->leftjoin('inventories', 'products.id', '=', 'inventories.product_id')
		->newQuery();

		return $result;
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
			['data' => 'id', 'visible' => false],
			['data' => 'supplier_id', 'title' => __('products.supplier_id'), 'name' => 'suppliers.id', 'visible' => false],
			['data' => 'supplier_name', 'title' => "Clave", 'name' => 'suppliers.name'],
			['data' => 'name', 'title' => __('products.name')],
			['data' => 'price_base', 'title' => __('products.price_base')],
			['data' => 'amount', 'title' => "C.", 'name' => 'inventories.amount'],
			['data' => 'category_id', 'title' => __('products.category_id'), 'name' => 'categories.name', 'visible' => false],
			['data' => 'barcode', 'title' => __('products.barcode'), 'visible' => false],
			['data' => 'unit_type_id', 'title' => __('products.unit_type_id'), 'name' => 'unit_types.name', 'visible' => false],
			['data' => 'display_name', 'title' => __('products.display_name'), 'visible' => false],
			['data' => 'color', 'title' => "Color", 'visible' => false],
			['data' => 'print_order', 'title' => __('products.print_order'), 'visible' => false],
			['data' => 'iva', 'title' => __('products.iva'), 'visible' => false],
			['data' => 'cost_base', 'title' => __('products.cost_base'), 'visible' => false],
			['data' => 'cost_min', 'title' => __('products.cost_min'), 'visible' => false],
			['data' => 'cost_max', 'title' => __('products.cost_max'), 'visible' => false],
			['data' => 'price_min', 'title' => __('products.price_min'), 'visible' => false],
			['data' => 'price_max', 'title' => __('products.price_max'), 'visible' => false],
			['data' => 'overprice', 'title' => __('products.overprice'), 'visible' => false],
			['data' => 'is_saleable', 'title' => __('products.is_saleable'), 'visible' => false],
			['data' => 'is_ticketable', 'title' => __('products.is_ticketable'), 'visible' => false],
			['data' => 'is_discountable', 'title' => __('products.is_discountable'), 'visible' => false],
			['data' => 'is_favorite', 'title' => __('products.is_favorite'), 'visible' => false],
			['data' => 'is_consigment', 'title' => __('products.is_consigment'), 'visible' => false],
			['data' => 'is_product', 'title' => __('products.is_product'), 'visible' => false],
			['data' => 'notes', 'title' => __('products.notes'), 'visible' => false],
			['data' => 'is_active', 'title' => __('products.is_active')],
			['data' => 'created_by', 'visible' => false],
			['data' => 'updated_by', 'visible' => false],
			['data' => 'created_at', 'visible' => false],
			['data' => 'updated_at', 'visible' => false],
		];
		if ($this->type == "pos") {
			$columns = [
				['data' => 'id', 'visible' => false],
				['data' => 'barcode', 'visible' => false],
				['data' => 'supplier_id', 'title' => __('products.supplier_id'), 'name' => 'suppliers.id', 'visible' => false],
				['data' => 'supplier_name', 'title' => __('suppliers.key'), 'name' => 'suppliers.name'],
				['data' => 'amount', 'title' => "C.", 'name' => 'inventories.amount'],
				['data' => 'name', 'title' => __('clients.name')],
				['data' => 'price_base', 'title' => __('Precio')],
			];
		}

		return array_merge($columns, $pColumns);
	}

	public function getBuilderParameters()
	{	
		$result = [
			'pageLength' => 100,
			'lengthMenu'=> [
				[100,200,300],
				[100,200,300],
			],
			'dom' => 'lfrtip',
			'serverSide' => true,
			'processing' => true,
			'responsive' => true,
			'createdRow' => "function( row, data, dataIndex ) {
				$(row).attr('data-id', data.id);
				$(row).attr('onclick', 'selectProduct(this, \'' + btoa(JSON.stringify(data)) + '\')');
				$(row).addClass('product-table-row');
			}",
			'columnDefs' => [
				['responsivePriority' => 1, 'targets' => 1],
				['width' => '30%', 'targets' => 3, 'className' => 'text-wrap'],
				['width' => '40%', 'targets' => 5, 'className' => 'text-wrap'],
				['width' => '10%', 'targets' => 4, 'className' => 'text-center'],
				['width' => '10%', 'targets' => 6, 'className' => 'text-end'],

			],
			'drawCallback' => 'function() { customizeDatatable(false) }',
		];

		if ($this->type != 'pos') {
			$result = array_merge($result,
				[
					'columnDefs' => [
						['responsivePriority' => 1, 'targets' => 3],
						['targets' => 2, 'className' => 'text-wrap'],
						['targets' => 3, 'className' => 'text-wrap'],
						['targets' => 4, 'className' => 'text-end'],
						['targets' => 5, 'className' => 'text-center'],
						['targets' => 26, 'className' => 'text-center'],
					],
					'buttons' => [
						['extend' => 'colvis', 'text' => 'Mostrar/Ocultar Columnas', 'className' => 'btn btn-primary'],
						[
							'extend' => 'excel',
							'text' => '<i class="fas fa-file-excel"></i> Exportar a excel',
							'className' => 'btn btn-success',
							'exportOptions' => [
								'columns' => [1, 2, 3, 4, 5, 6,10,11,12,13,14,15,16,18,19,20,21,22,23,25] // Aquí especifica los índices de las columnas que deseas exportar
							]
						]
					],
					'dom' => 'lBrtip',
					'pagingType' => 'full_numbers',
					'stateSave' => false,
					'pageLength' => 15,
					'lengthMenu'=> [
						[15,100,200,300,500,1000, -1],
						[15,100,200,300,500,1000, "TODOS"],
					],
					'drawCallback' => 'function() { 
						customizeDatatable(false, true, false)
					}',
				]
			);
		}

		if ($this->type == 'pos') {
			$result['searching'] = true;
			$result['initComplete'] = "function() {
				$('#products-table_wrapper').addClass('d-none').removeClass('d-block')

			}";

			$result['drawCallback'] = "function() {
				var dataTable = this.api();
				var input = $('#filter');
				input.off('keyup').on('keyup', function(event) {
					if (event.keyCode === 13) {
						event.preventDefault();
						dataTable.search(this.value).draw();
						isEnter = true;
					}
					if (input.val() == '') {
						$('#products-table_wrapper').addClass('d-none').removeClass('d-block')
						$('#message-search-scan').addClass('d-block').removeClass('d-none')
					}
				});

				$('#btnClearSearch').off().click(function() {
					input.val('');
					dataTable.search(input.val()).draw();
					isEnter = false;
					$('#products-table_wrapper').addClass('d-none').removeClass('d-block')
					$('#message-search-scan').addClass('d-block').removeClass('d-none')
				});

				$('#btnSearch').off().click(function() {
					dataTable.search(input.val()).draw();
					isEnter = false;
				});

			
				// Comprobar si el filtrado ha finalizado después de dibujar el DataTable
				if ((!dataTable.settings()[0].oFeatures.bFilter || !dataTable.settings()[0].oFeatures.bFiltering) && input.val() != '') {
					$('#products-table_wrapper').addClass('d-block').removeClass('d-none')
					$('#message-search-scan').addClass('d-none').removeClass('d-block')
						if (isEnter) {
							$('#products-table .product-table-row').first().trigger('click')
							$('#filter').val('')
							isEnter = false;
						}
					}
				customizeDatatable(false);
			}";
		}

		return $result;
	}

	public function getActions($row)
	{
		$result = '';

		if(auth()->user()->hasPermissions($this->routeResource.".edit")) {
			$result .= '
				<a class="btn btn-default" title="'.__('edit').'" href="'.route($this->routeResource.".edit", $row->id).'">
					<i class="mdi mdi-pencil icon-edit font-size-18"></i>
				</a>';
		}

		if(auth()->user()->hasPermissions($this->routeResource.".destroy")) {
			$result .= '
				<a class="btn btn-default" title="'.__('delete').'" onclick="showDeleteModal(\''.$this->routeResource.'\', '.$row->id.')">
					<i class="mdi mdi-delete icon-delete font-size-18"></i>
				</a>';
		}

		return $result;
	}

	public function dataTable($query)
	{

		$datatable = parent::dataTable($query);
		$datatable->filter(function($query) {
			// $query->orWhere('categories.name', 'LIKE', '%'.request('search.value').'%');
			// $query->orWhere('unit_types.name', 'LIKE', '%'.request('search.value').'%');
			if (request()->supplier_key != null){
				$query->where('suppliers.id', 'LIKE', '%'.intval(request()->supplier_key).'%');
			}
			if (request()->supplier_name != null){
				$query->where('suppliers.name', 'LIKE', '%'.request()->supplier_name.'%');
			}
			if (request()->is_active != null && request()->is_active != "2"){
				$query->where('products.is_active', request()->is_active);
			}
			if (request()->product_name != null){
				$query->where('products.name', 'LIKE', '%'.request()->product_name.'%');
				$query->orWhere('products.barcode', 'LIKE', '%'.request()->product_name.'%');
			}
		}, true)->editColumn('url_image', function ($row) {
			$url = $row->url_image == 'no-image.png' ? asset('images')."/".$row->url_image : asset($row->url_image);
			$color = $row->color == '' ? '#26a9e1' : $row->color;
			return $row->url_image!=null||!empty($row->url_image)?'<img style="background-color:'.$color.'" src="'.$url.'" border="0" height="50" class="img-rounded" align="center" />':'';
		})->editColumn('color', function ($row) {
			return $row->color!=="" ? "<span style='border: 3px solid ".$row->color."; padding: 5px; border-radius: 5px'>".$row->color."</span>" : "";
		})->editColumn('price_base', function ($row) {
			return "$".number_format($row->price_base, 2, '.', ',');
		})->editColumn('price_max', function ($row) {
			return "$".number_format($row->price_max, 2, '.', ',');
		})->editColumn('price_min', function ($row) {
			return "$".number_format($row->price_min, 2, '.', ',');
		})->editColumn('cost_base', function ($row) {
			return "$".number_format($row->cost_base, 2, '.', ',');
		})->editColumn('cost_max', function ($row) {
			return "$".number_format($row->cost_max, 2, '.', ',');
		})->editColumn('cost_min', function ($row) {
			return "$".number_format($row->cost_min, 2, '.', ',');
		})->editColumn('is_active', function ($row) {
			return $row->is_active ? "Sí" : "No";
		})->editColumn('supplier_name', function ($row) {
			if ($this->type == 'pos') {
				return $row->supplier_id == null ? 'N/A'." - ".$row->barcode : Supplier::find($row->supplier_id)->name." - ".$row->barcode;
			}else{
				return $row->supplier_name ?? "N/A";
			}
		})->rawColumns(["url_image", "action", 'color']);
	
		return $datatable;
	}

	public function html()
	{	

		$result = $this->builder()
			->parameters($this->getBuilderParameters())
			->setTableId($this->routeResource.'-table')
			->addTableClass('nowrap')
			->columns($this->getColumns())
			->minifiedAjax()
			->responsive('true')
			->language(asset('js/datatables/datatables_Spanish.json'));

		if ($this->type == 'pos'){
			$result = $result->responsive(false);
		}

		return $result;
	}
}