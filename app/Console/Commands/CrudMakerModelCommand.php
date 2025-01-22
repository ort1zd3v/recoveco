<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;

class CrudMakerModelCommand extends CrudMakerBaseCommand
{
	protected $signature = 'crudmaker:model 
		{name : Entity (Example: "User", "Student").} 
		{--table= : Define a database table in case the name is different from model name.}
		{--no-warning}';
	protected $description = "Generate model with fillable fields and relations";

	public function handle()
	{
		if($this->validateInputData()) {
			$this->createModel();
		}
	}

	/**
	 * [createModel Generates model component]
	 * @return [type] [description]
	 */
	private function createModel()
	{
		$template = $this->stubDir.'model.stub';
		$file = $this->laravel['path'].'/Models/'.str_replace('\\', '/', $this->modelName).'.php';
		$this->backupFile($file);
		$this->makeDirectory($file);

		/** Convert array fields into an string to replace in the template */
		$fillableFields = "";
		foreach ($this->arrFields as $key => $field) {
			if($field->COLUMN_NAME != "id")
				$fillableFields .= "'".$field->COLUMN_NAME."', ";
		}
		$fillableFields = substr($fillableFields, 0, -2);
		/**  */

		$strConstraints = $this->generateConstraints();

		$search = ['{{ fillableFields }}', '{{ constraints }}'];
		$replace = [$fillableFields, $strConstraints];
		$stub = $this->getStubContent($template, $search, $replace);

		$this->files->put($file, $this->sortImports($stub));
		$this->info('Model created successfully.');
	}

	/**
	 * [generateConstraints For each table constraint we generate a relation belongsTo or hasMany]
	 * @return [type] [description]
	 */
	private function generateConstraints()
	{
		$constraints = $this->getConstraints();
		$btString = ''; //"belongs to" string to insert in the stub
		$hmString = ''; //"has many" string to insert in the stub

		//Generate the text for "belongs to" relation
		foreach ($constraints["belongsTo"] as $key => $btConstraint) {
			if(in_array($btConstraint["field"], ["created_by", "updated_by"])) {
				$rName = Str::camel($btConstraint["field"]);
				$mName = "User";
			} else {
				$tName = str_replace("_id", "", $btConstraint["field"]);
				$rName = Str::camel($tName);
				$mName = $this->strTableToModel($btConstraint["tablename"]);
			}

			$btString .= "public function ".$rName."()
	{
		return \$this->belongsTo('App\\Models\\".$mName."', '".$btConstraint["field"]."');
	}\n\t";
		}


		//Generate the text for "has many" relation
		if(!empty($constraints["hasMany"]))
			$btString .= "\n\t";

		foreach ($constraints["hasMany"] as $key => $hmConstraint) {
			$hmString .= "public function ".Str::plural(Str::camel($hmConstraint["tablename"]))."()
	{
		return \$this->hasMany('App\\Models\\".$this->strTableToModel($hmConstraint["tablename"])."');
	}\n\t";
			if(array_key_last($constraints["hasMany"]) !== $key)
				$hmString .= "\n\t";
		}

		//$btString = trim(preg_replace('/\t+/', '', $btString));
		//$hmString = trim(preg_replace('/\t+/', '', $hmString));

		return ($btString.$hmString);
	}
}
