<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;

class CrudMakerDatatableCommand extends CrudMakerBaseCommand
{
	protected $signature = 'crudmaker:datatable 
		{name : Entity (Example: "User", "Student").} 
		{--table= : Define a database table in case the name is different from model name.}
		{--no-warning}';
	protected $description = "Generate model with fillable fields and relations";

	public function handle()
	{
		if($this->validateInputData()) {
			$this->createDatatable();
		}
	}

	private function createDatatable()
	{
		$file = $this->laravel['path'].'/DataTables/'.str_replace('\\', '/', $this->datatableName).'.php';
		$template = $this->stubDir.'datatable.stub';
		$this->backupFile($file);
		$this->makeDirectory($file);

		//query contruct
		$query = "return \$model";
		$relations = $this->getAllBelongstoRelations();
		$arrRelations = [];
		if(!empty($relations)) {
			$query .= "->select(
			'".$this->routeResource.".*',";

			//Search for every relation to get the first varchar column as selected column on query
			foreach ($relations as $key => $relation) {
				$displayField = $this->getDisplayField($relation["tablename"]);
				$query .= "\n\t\t\t'".$relation["tablename"].".".$displayField." as ".$relation["field"]."',";
				$arrRelations[$relation["field"]] = $relation["tablename"].".".$displayField;
			}
			$query = substr($query, 0, -1); //Remove last comma
			$query .= "
		)";
			foreach ($relations as $key => $relation) {
				$query .= "\n\t\t->leftjoin('".$relation["tablename"]."', '".$this->routeResource.".".$relation["field"]."', '=', '".$relation["tablename"].".id')";
			}
		}
		$query .= "\n\t\t->newQuery();";

		// Convert array fields into an string to replace in the template
		$columns = "";
		foreach ($this->arrFields as $key => $field) {
			$columns .= "['data' => '".$field->COLUMN_NAME."', ";
			if(in_array($field->COLUMN_NAME, $this->ignoreColumns))
				$columns .= "'visible' => false, 'title' => __('".$this->translations.".".$field->COLUMN_NAME."')";
			else
				$columns .= "'title' => __('".$this->translations.".".$field->COLUMN_NAME."')";

			if($arrRelations[$field->COLUMN_NAME] ?? false) {
				$columns .= ", 'name' => '".$arrRelations[$field->COLUMN_NAME]."'";
			}
			$columns .= "],";
			if($field->COLUMN_NAME != ($this->arrFields->last())->COLUMN_NAME)
				$columns .= "\n\t\t\t";
		}

		$search = ['{{ columns }}', '{{ query }}'];
		$replace = [$columns, $query];
		$stub = $this->getStubContent($template, $search, $replace);

		$this->files->put($file, $this->sortImports($stub));
		$this->info($this->datatableName.' created successfully.');
	}
}
