<?php
namespace App\Classes;

use Illuminate\Support\Facades\Route as RouteBase;
use Illuminate\Support\Str;

class Route extends RouteBase
{
	static function resourceModals(string $name, string $controller, array $options = [])
	{
		static::addRoute($name, $controller, 'getquickmodalcontent');
		static::resource($name, $controller, $options);
	}

	static function addRoute(string $entity, string $controller, string $name)
	{
		$param = Str::singular(Str::snake($entity));
		Route::get($entity.'/'.$name.'/{'.$param.'?}', [$controller, Str::camel($name)])->name($entity.'.'.$name);
	}
}