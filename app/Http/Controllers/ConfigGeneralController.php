<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\Font;
use App\Http\Controllers\TemplateController;

class ConfigGeneralController extends Controller
{
    public function index()
	{
		$templates = Template::pluck('name', 'id');
		$fonts = Font::pluck('name', 'id');

		$template = TemplateController::readTemplateJson();
		return view('config-general.index', compact('templates', 'fonts', 'template'));
	}

	public function getPartOfPreview($view, $idTheme)
	{
		$template = Template::find($idTheme)->data;
		$template = json_decode($template);
		if ($view != '') {
			return view('components.configTemplates.'.$view, compact('template'));
		}
	}
}
