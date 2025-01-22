<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfigPos;
use App\Models\ConfigProduct;
use App\Models\ConfigCart;
use App\Models\ConfigPayment;
use App\Models\ConfigTicket;
use App\Models\ConfigClient;
use App\Models\Category;
use App\Models\Product;
use App\Models\Client;
use App\Models\Selling;
use App\Models\SellingRow;
use App\Models\PaymentType;
use App\Models\Payment;
use App\Models\User;
use App\Models\StartingFound;

use Illuminate\Contracts\Database\Eloquent\Builder;
use App\DataTables\ProductDataTable;

use App\Http\Controllers\SellingController as SellingCon;
use Illuminate\Support\Facades\View;

class PosController extends Controller
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

		return view('pos.index', compact('config'));
	}

	/**
	 * Genera un arreglo compacto con las variables necesarias para una vista determinada.
	 *
	 * @param string $view El nombre de la vista ('productos', 'carrito' o 'pago').
	 * @return array Un arreglo compacto con las variables necesarias para la vista.
	 */
	public static function getCompact($view)
	{
		$result = null;
		$template = TemplateController::readTemplateJson();

		switch ($view) {
			case 'productos':
				$configProducts = json_decode(ConfigProduct::first()->data);
				$categories = Category::with(['products' => function (Builder $query) {
					$query->where('is_saleable', true)->where('is_active', true)->orderBy('print_order', 'asc');
				}])->where('is_visible', true)->orderBy('print_order', 'asc')->get();

				$allProducts = Product::whereRelation('category', 'is_visible', true)->where('is_saleable', true)->where('is_active', true)->get();
				$result = compact('configProducts', 'categories', 'template', 'allProducts');

				break;
			case 'carrito':
				$configCarts = json_decode(ConfigCart::first()->data);
				$configPayments = json_decode(ConfigPayment::first()->data);
				$configClients = ConfigClient::first();
				$result = compact('configCarts', 'configPayments', 'configClients', 'template');
				break;

			case 'pago':
				$configPayments = json_decode(ConfigPayment::first()->data);
				$configClients = ConfigClient::first();
				$result = compact('configPayments', 'configClients', 'template');
				break;
		}

		return $result;
	}

	public function getIngredientsModal(Product $product)
	{
		$template = TemplateController::readTemplateJson();
		$configProducts = json_decode(ConfigProduct::first()->data);
		$amount = request('amount');
		$tabs = ["Abajo", "En medio", "Arriba"];
		$allComboProducts = $product->getAllProductIngredients();
		$result = ["product" => $product, "content" => ""];
		foreach ($allComboProducts as $key => $p) {
			$product = $p["product"];
			$ingredients = $p["ingredients"];
			$result["content"] .= view(
				'pos.modal-ingredients',
				compact('product', 'ingredients', 'template', 'configProducts', 'amount', 'tabs')
			)->render();
		}

		return response()->json($result);
	}

	/**
	 * Abre el modal para actualizar los ingredientes de un producto
	 * 
	 * @param $uniqueId - es el data-unique-id que tiene el producto principal del row
	 * @param $buttonId - es el id del botón desde donde se está ejecutnado el edit
	 * 
	 * @return json con el modal
	 */
	public function updateIngredientsModal($uniqueId, $buttonId)
	{
		$product = Product::find(request()->product_id);
		$selectedIngredients = request()->ingredients ?? [];
		$totalIngredients = 0;

		foreach ($selectedIngredients as &$arrayIngredients) {
			$totalIngredients += count($arrayIngredients);
			foreach ($arrayIngredients as $key => &$ingredient) {
				$productIngredient = Product::find($ingredient['product_id']);
				$ingredient['url_image'] = $productIngredient->url_image;
				$ingredient['color'] = $productIngredient->color;
			}
		}
		unset($ingredient); // desreferenciar el último elemento del arreglo interno
		unset($arrayIngredients); // desreferenciar el último arreglo interno

		$template = TemplateController::readTemplateJson();
		$configProducts = json_decode(ConfigProduct::first()->data);
		$amount = request('amount');
		$tabs = ["Abajo", "En medio", "Arriba"];


		$allComboProducts = $product->getAllProductIngredients();

		$result = ["product" => $product, "content" => ""];
		$ingredients = $allComboProducts[$product->id]['ingredients'];
		$result["content"] = view(
			'pos.modal-ingredients',
			compact(
				'product',
				'ingredients',
				'template',
				'configProducts',
				'amount',
				'tabs',
				'selectedIngredients',
				'totalIngredients',
				'uniqueId',
				'buttonId'
			)
		)->render();

		return response()->json($result);
	}


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
		$result = null;
		$allIngredients = request('allIngredients');
		$amount = request('amount');
		$result = response()->json(view('pos.cart-row-ingredients', compact('product', 'allIngredients', 'uniqueId', 'amount'))->render());
		return $result;
	}

	public function saveSale(Request $request)
	{
		$result = (new SellingCon)->saveSelling(request()->all());

		if (!$result["status"]) {
			$result = $this->getResponse($result["status"], $result["message"]);
		} else {
			extract($result);
			$data = ($status ? $this->getTicket($selling->id) : null);
			$result = $this->getResponse($status, $message, $data);
		}
		return $result;
	}

	public function getTicket($selling_id)
	{
		$config_ticket = ConfigTicket::first();
		$user = User::find(auth()->id());
		$selling = Selling::find($selling_id);
		return view('config-tickets.ticket', compact('config_ticket', 'user', 'selling'))->render();
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
				} else {

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
