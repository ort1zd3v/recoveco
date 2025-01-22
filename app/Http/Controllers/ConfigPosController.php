<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfigPos;
use App\Models\ConfigProduct;
use App\Models\ConfigCart;
use App\Models\ConfigPayment;

use App\Models\Category;
use Illuminate\Support\Facades\View;

class ConfigPosController extends Controller
{
    public function index()
	{
		$config = json_decode(ConfigPos::first()->data);
		return view('config-pos.index', compact('config'));
	}

	public function update(Request $request)
	{
		$status = true;
		$configPos = ConfigPos::first();
		$params = [
            'data' => json_encode($request->all()),
			'updated_by' => auth()->id(),
			'updated_at' => date("Y-m-d H:i:s")
		];
		
		try {
			$configPos->update($params);
			$message = __('templates.Successfully updated');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'templates');
		}

		return redirect()->route('config_pos.index');
	}

	/**
	 * Obtiene las vistas disponibles a partir de la configuración de la POS.
	 *
	 * @return array Un arreglo con las vistas disponibles.
	*/
	public function getViews()
	{
		$tiles = json_decode(ConfigPos::first()->data)->tiles;
		$views = [];
		foreach ($tiles as $key => $value) {
			$views[$key] = $value;
        }
		return $views;
	}

	public function getView($view)
	{
		if (View::exists('components.windows.'.$view)) {
			return view('components.windows.'.$view, PosController::getCompact($view));
		}
	}

	public function getConfigView($view)
	{
		if (View::exists('components.configWindows.'.$view)) {
			return view('components.configWindows.'.$view, PosController::getCompact($view));
		}
	}

	public function saveConfigView(Request $request)
	{
		return response()->json($this->saveConfig($request->data, $request->view));
	}

	//por ajax
	public function saveConfig($data, $view)
	{
		$status = true;
		
		if ($view == 'productos') {
			$config = ConfigProduct::first();
			$data['with_tabs'] = $data['with_tabs'] === "true";
			$data['with_keyboard'] =  $data['with_keyboard'] === "true";
			$data['with_filters'] =  $data['with_filters'] === "true";
		} elseif ($view == 'carrito') {
			$config = ConfigCart::first();
			$data['pay_inline'] = $data['pay_inline'] === "true";
			$data['in_modal'] = $data['in_modal'] === "true";
		} elseif ($view == 'pago') {
			$config = ConfigPayment::first();
			$data['with_cash'] = $data['with_cash'] === "true";
			$data['with_credit'] = $data['with_credit'] === "true";
			$data['with_gift_card'] = $data['with_gift_card'] === "true";
		}

		$params = [
            'data' => json_encode($data),
			'updated_by' => auth()->id(),
			'updated_at' => date("Y-m-d H:i:s")
		];

		try {
			$config->update($params);
			$message = __('templates.Successfully updated');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'templates');
		}
		$data['success'] = $status;
		return $data;	
	}

}
