<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ConfigPos;

use Illuminate\Http\Request;

class InventoryMultiMovementController extends Controller
{
    public function index()
	{
		// $p = Product::find(1);
		// dd($p->hasIngredients());
		$config = json_decode(ConfigPos::first()->data);
		
		foreach ($config->tiles as $key => $value) {
			$config->tiles->{$key} = [
				"title" => $value,
				"data" => $this->getCompact($value),
			];
		}
		return view('inventories-multi-movements.index', compact('config'));
	}

	/**
	 * Genera un arreglo compacto con las variables necesarias para una vista determinada.
	 *
	 * @param string $view El nombre de la vista ('productos', 'carrito' o 'pago').
	 * @return array Un arreglo compacto con las variables necesarias para la vista.
	 */
	public static function getCompact($view)
	{
		
	}

	public function getIngredientsModal(Product $product)
	{
		
		
	}

	/**
	 * Abre el modal para actualizar los ingredientes de un producto
	 * 
	 * @param $uniqueId - es el data-unique-id que tiene el producto principal del row
	 * @param $buttonId - es el id del botón desde donde se está ejecutnado el edit
	 *         return (new InventoryMovementDataTable())->render('inventory-movements.index', compact('allowAdd', 'allowEdit', 'inventoryMovementTypes'));
	 * @return json con el modal
	 */	
	
	public function addCartProduct(Product $product)
	{
		$result = null;
		$amount = request('amount');
		$allIngredients = request('allIngredients');

		/*if ($allIngredients ?? false) {
			foreach ($allIngredients as $key => $row) {
				$allIngredients[$key]["products"] = (Product::find($row["product_id"]))->getComboProducts();
			}
		}*/
		$result = response()->json(view('pos.cart-row', compact('product', 'amount', 'allIngredients'))->render());

		return $result;
	}


	/**
	 * Agrega únicamente la fila del ingrediente editada debajo del row del padre
	 * 
	 * @param $uniqueId - es el data-unique-id que tiene el producto principal del row
	 * @param $product - id de producto desde la url get
	 * 
	 * @return json con la vista
	 */
	public function addIngredientProduct(Product $product, $uniqueId)
	{
		
	}

	public function saveSale(Request $request)
	{
		
	}

	public function getTicket($selling_id)
	{
	
	}


	public function searchProduct($param)
	{
		$supplierId = null;
		$secondValue = null;
		$filter = null;

		if (strpos($param, ' - ') !== false) {
			$param = str_replace(' - ', '-', $param);
		}

		if (strpos($param, '-') !== false) {
			list($supplierId, $secondValue) = explode('-', $param, 2);
			$secondValue = $secondValue;
		} else {
			$filter = $param;
		}

		$supplierId = ltrim($supplierId, "0");

		$products = Product::where('is_saleable', true)
			->where('is_active', true)
			->where(function ($query) use ($supplierId, $secondValue, $filter) {

				if ($filter !== null) {
					$filter = ltrim($filter, "0");

					$query->where('supplier_id', 'like', '%' . $filter . '%')
							->orWhere('name', 'like', '%' . $filter . '%')
							->orWhere('barcode', 'like', '%' . $filter . '%');
				}else{

					$query->where(function ($query) use ($supplierId, $secondValue) {
						$query->where('supplier_id', $supplierId);
						$query->where(function ($query) use ($supplierId, $secondValue) {
							$query->where('barcode', 'like', '%' . $secondValue . '%')
								->orWhere('name', 'like', '%' . $secondValue . '%');

						});
					});
				}
			})
			->orderBy('products.name', 'asc')
			->limit(400)
			->get();
		

		
		$products = $products->map(function ($product) {
			$product->supplier_name = $product->supplier->name ?? "N/A"; // Agregar el nombre del proveedor al array del producto
			$product->amount = $product->inventories[0]->amount ?? "0"; 

			return $product;
		});
		

		return $products;
	}
}
