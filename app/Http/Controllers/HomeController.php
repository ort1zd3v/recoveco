<?php

namespace App\Http\Controllers;

use App\GraphGenerator\GraphFactory;
use App\Http\Controllers\DashboardController;
 
class HomeController extends Controller
{
	public function index()
	{
		$data = [];
		return view('home', compact('data'));
	}
}
