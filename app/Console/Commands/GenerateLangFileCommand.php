<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class GenerateLangFileCommand extends GeneratorCommand
{
	protected $signature = 'lang:make';
	
	protected $description = "Compiles and exports lang file to javascript file";
	
	public function handle()
	{
		//if ($this->confirm('The files will be rewrited. Do you want to continue?')) {
			//$name = ucfirst($this->getNameInput());
			$name = "lang";
			$directory = $this->laravel['path.resources'].'/js/';
			//The function makeDirectory accepts a path with file name to create his directory
			$this->makeDirectory($directory.$name.".js");

			$lang = config('app.locale');
			$files = glob(base_path().'/lang/'.config('app.locale').'/*.php');
			//$files   = glob(resource_path('lang/'.$lang.'/*.php'));
			$strings = [];

			foreach ($files as $file) {
				$name = basename($file, '.php');
				$strings[$name] = require $file;
			}

			$content = 'window.i18n = '.json_encode($strings).';';
			$this->files->put($directory."lang.js", $content);
			$this->info('lang.js file created successfully.');
		//}
	}

	protected function getStub()
	{
		return "";
	}
}
