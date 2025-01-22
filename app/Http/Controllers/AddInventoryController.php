<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AddInventoryController extends Controller
{
	public function index()
	{
		return view('add-inventories.index');
	}

}
