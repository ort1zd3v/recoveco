<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Traits\QueryFilters;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests, QueryFilters;

	public $defaultParams;

	public function __construct()
	{
		$this->defaultParams = [
			'is_active' => 1,
			'created_by' => auth()->id(),
			'updated_by' => auth()->id(),
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s")
		];
	}

	public function getQueryWithParams($query)
	{
		return vsprintf(str_replace('?', '%s', str_replace('%', '%%', $query->toSql())), collect($query->getBindings())->map(function ($binding) {
			return is_numeric($binding) ? $binding : "'{$binding}'";
		})->toArray());
	}

	public function getErrorMessage($e, $translations)
	{
		if($e->getCode() == "23000") {
			$error = __($translations.'.delete_error_message_constraint');
		}
		else {
			$error = __($translations.'.delete_error_message');
		}
		
		return $error.'. <br>
			<a href="#" data-bs-toggle="collapse" data-bs-target="#errorDetails">'.__('Show details').':</a>
			<span id="errorDetails" class="collapse" aria-expanded="false">'.$e->getMessage().'</span>';
	}

	public function getResponse($status, $message, $data = null)
	{
		if(request()->expectsJson()) {
			$response = ["status" => $status, "message" => $message];
			if($data !== null) {
				$response["data"] = $data;
			}
			$result = response()->json($response, 200);
		} else {
			session()->flash($status ? 'message' : 'error', $message);
			$result = redirect()->route((explode(".", request()->route()->getName()))[0].".index");
		}

		return $result;
	}
}
