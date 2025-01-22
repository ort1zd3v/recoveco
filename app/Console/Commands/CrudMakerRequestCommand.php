<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;

class CrudMakerRequestCommand extends CrudMakerBaseCommand
{
	protected $signature = 'crudmaker:request 
		{name : Entity (Example: "User", "Student").} 
		{--table= : Define a database table in case the name is different from model name.}
		{--no-warning}';
	protected $description = "Generate model with fillable fields and relations";

	public function handle()
	{
		if($this->validateInputData()) {
			$this->createRequest();
		}
	}

	/**
	 * [createRequest Generates controller component]
	 * @return [type] [description]
	 */

	private function createRequest()
	{
		$template = $this->stubDir.'request.stub';
		$file = $this->laravel['path'].'/Http/Requests/'.str_replace('\\', '/', $this->validatorName).'.php';
		$this->backupFile($file);
		$this->makeDirectory($file);

		// Convert array fields into an string to replace in the template
		$columns = "";
		foreach ($this->arrFields as $key => $field) {
			if(!in_array($field->COLUMN_NAME, $this->ignoreColumns)) {
			//if($field->COLUMN_NAME != "id") {
				$cColumn = "'".$field->COLUMN_NAME."' => '";
				$val = "";
				if($field->IS_NULLABLE == "NO")
					$val .= "required|";
				if($field->COLUMN_KEY == "UNI")
					$val .= "unique:".$this->dbTable."|";
				if($field->DATA_TYPE == "varchar") {
					$val .= "max:".$field->CHARACTER_MAXIMUM_LENGTH."|";
				}


				if($val != "") {
					$val = substr($val, 0, -1);
					$cColumn .= $val;
					$cColumn .= "',";
					if($field->COLUMN_NAME != ($this->arrFields->last())->COLUMN_NAME)
						$cColumn .= "\n\t\t\t";
					$columns .= $cColumn;
				}
			}
		}

		$search = ['{{ columns }}'];
		$replace = [$columns];
		$stub = $this->getStubContent($template, $search, $replace);

		$this->files->put($file, $this->sortImports($stub));

		$this->info($this->validatorName.' created successfully.');
	}
}
