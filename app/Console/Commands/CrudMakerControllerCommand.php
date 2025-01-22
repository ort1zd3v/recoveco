<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;

class CrudMakerControllerCommand extends CrudMakerBaseCommand
{
	protected $signature = 'crudmaker:controller 
		{name : Entity (Example: "User", "Student").} 
		{--table= : Define a database table in case the name is different from model name.}
		{--no-warning}';
	protected $description = "Generate model with fillable fields and relations";

	public function handle()
	{
		if($this->validateInputData()) {
			$this->createController();
		}
	}

	/**
	 * [createController Generates controller component]
	 * @return [type] [description]
	 */
	private function createController()
	{
		$template = $this->stubDir.'controller.stub';
		$file = $this->laravel['path'].'/Http/Controllers/'.str_replace('\\', '/', $this->modelName."Controller").'.php';
		$this->backupFile($file);
		$this->makeDirectory($file);

		$search = ['{{ compactedInstace }}', '{{ modelImports }}', '{{ catalogs }}', '{{ createParams }}', '{{ editParams }}', '{{ paramsList }}'];
		$replace = array_merge([$this->compactInstace], $this->getControllerParams());
		$stub = $this->getStubContent($template, $search, $replace);
		
		$this->files->put($file, $this->sortImports($stub));
		$this->info('Controller created successfully.');
	}

	private function getControllerParams()
	{
		$modelImports = "use App\\Models\\".$this->modelName.";\n";
		$catalogs = "";
		$params = null;

		//Iterate belongsto relationships to add the imports and the catalog consult on create, edit views
		foreach ($this->getAllBelongstoRelations() as $key => $relation) {
			$cModel = $this->strTableToModel($relation["tablename"]);
			$modelImports .= "use App\\Models\\".$cModel.";\n";

			$catInstance = Str::plural(Str::camel($relation["tablename"]));
			$displayField = $this->getDisplayField($relation["tablename"]);

			//If the table has the description column then we'll retreive data to fill a select
			if($displayField == "name") {
				$catalogs .= "$".$catInstance." = ".$cModel."::orderBy('".$displayField."', 'asc')->pluck('".$displayField."', 'id');\n\t\t";

				//Array with all objects to pass to view
				$params[] = $catInstance;
			}
		}

		$createParams = "";
		$editParams = "";
		if($params != null) {
			$createParams = ", compact(".$this->getCompactParams($params).")";
		}
		//For edit params we always add the instance itself
		$params = array_merge([$this->compactInstace], $params ?? []);
		$editParams = ", compact(".$this->getCompactParams($params).")";
		$paramsList = $this->getCompactParams($params);

		if($catalogs != "") {
			$catalogs .= "\n\t\t";
		}

		return compact('modelImports', 'catalogs', 'createParams', 'editParams', 'paramsList');
	}

	private function getCompactParams($params = [])
	{
		$result = "";
		foreach ($params as $key => $param) {
			$result .= "'".$param."',";
		}
		return substr($result, 0, -1);
	}
}
