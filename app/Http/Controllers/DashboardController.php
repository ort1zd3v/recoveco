<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\ProductController;

class DashboardController extends Controller
{
	public function index()
	{
		$tableView = (new ProductController)->getProductTableView();
		return view('dashboard.index', compact('tableView'));
	}
}



