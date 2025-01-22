<?php

namespace App\DataTables;

use App\Models\Ingredient;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class IngredientDataTable extends BlankDataTable
{
	public $productId;

	public function __construct($productId = null)
	{
		$this->routeResource = 'ingredients';
		$this->productId = $productId;
	}
	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\Selling $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(Ingredient $model)
	{
		$model = $model->select(
			'ingredients.*',
			'categories.name as category_id',
			'products.name as ingredient_id',
			'products2.name as product_id'
		)
		->leftjoin('categories', 'ingredients.category_id', '=', 'categories.id')
		->leftjoin('products', 'ingredients.ingredient_id', '=', 'products.id')
		->leftjoin('products as products2', 'ingredients.product_id', '=', 'products2.id');

		if($this->productId != null){
			$model = $model->where('product_id', $this->productId);
		}

		return $model->newQuery();
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
			['data' => 'amount', 'title' => __('ingredients.amount')],
			// ['data' => 'product_id', 'title' => __('ingredients.product_id'), 'name' => 'products.name'],
			['data' => 'category_id', 'title' => __('ingredients.category_id'), 'name' => 'categories.name'],
			['data' => 'ingredient_id', 'title' => __('ingredients.ingredient_id'), 'name' => 'products.name'],
			// ['data' => 'notes', 'title' => __('ingredients.notes')],
			// ['data' => 'is_active', 'title' => __('ingredients.is_active')],
			['data' => 'created_by', 'visible' => false],
			['data' => 'updated_by', 'visible' => false],
			['data' => 'created_at', 'visible' => false],
			['data' => 'updated_at', 'visible' => false],
		];
		return array_merge($columns, $pColumns);
	}

	public function getActions($row)
	{
		$result = '';
		if(auth()->user()->hasPermissions($this->routeResource.".destroy")) {
			$result .= '
				<button type="button" class="btn btn-default" title="'.__('delete').'" onclick="showDeleteModal(\''.$this->routeResource.'\', '.$row->id.')">
					<i class="mdi mdi-delete icon-delete font-size-18"></i>
				</button>';
		}

		return $result;
	}

	public function html()
	{	
		return $this->builder()
			->parameters($this->getBuilderParameters())
			->setTableId($this->routeResource.'-table')
			->addTableClass('nowrap')
			->columns($this->getColumns())
			->minifiedAjax(route('ingredients.getdatatable', $this->productId))
			->responsive('true')
			->language(asset('js/datatables/datatables_Spanish.json'));
	}

	public function getBuilderParameters()
	{	
		return [
			'pageLength' => 15,
			/*'lengthMenu'=> [
				[15,30,45, -1 ],
				[ 15, 30, 45, "Todos" ]
			],*/
			'dom' => 'frtip',
			'serverSide' => true,
			'processing' => true,
			'responsive' => true,
			'columnDefs' => [
				['responsivePriority' => 1, 'targets' => 2] 
			],
			'drawCallback' => 'function() { customizeDatatable() }'
		];
	}
}
