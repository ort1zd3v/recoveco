<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfigTablesController extends Controller
{
    public function index()
	{
		return view('config-tables.index');
	}
}
