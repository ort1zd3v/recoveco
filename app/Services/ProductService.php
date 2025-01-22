<?php

namespace App\Services;

use App\DataTables\ProductDataTable;

class ProductService {
    
	public function getHTMLProductDataTable(ProductDataTable $dataTable)
	{
		$dataTable->html()->minifiedAjax(route('products.getproducttableajax'), null, ['table' => true]);

		$html = $dataTable->html()
		->columns([
			['data' => 'id', 'visible' => false],
			['data' => 'name', 'title' => __('products.name'), 'responsivePriority' => 1],
			['data' => 'category_id', 'title' => __('products.category_id'), 'name' => 'categories.name', 'visible' => false],
			['data' => 'barcode', 'title' => __('products.barcode')]
		]);
		$parameters = $dataTable->getBuilderParameters();

		$parameters['dom'] = 'rtp';

		$html->parameters($parameters); 

		return $html;
	}
}