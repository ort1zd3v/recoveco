<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

abstract class CrudMakerBaseCommand extends GeneratorCommand
{
	protected $signature;
	protected $description;

	protected $backup = true;
	protected $stubDir = __DIR__.'/stubs/crud_maker/';
	protected $ignoreColumns = ["id", "created_at", "updated_at", "created_by", "updated_by", "deleted_at"];
	protected $modelName;
	protected $dbTable;
	protected $arrFields;
	protected $validatorName;
	protected $datatableName;
	protected $modelInstace; //variable name to invoke model
	protected $routeResource; //route resource in web file
	protected $translations; //translations file
	protected $templateDir; //views directory
	protected $permissions;
	protected $langContent;

	public function handle()
	{
		return "";
	}

	protected function getStub()
	{
		return "";
	}

	protected function validateInputData()
	{
		$result = false;

		$valid = true;
		/*if (!$this->option('no-warning')) {
			$valid = $this->confirm('The files will be replaced. Do you want to continue?');
		}*/

		if($valid) {
			if (!$this->isReservedName($this->getNameInput())) {
				$this->modelName = ucfirst($this->getNameInput());
				$this->dbTable = $this->getTablename();
				$this->arrFields = $this->getTablefields();
				$this->datatableName = $this->modelName.'DataTable';
				$this->routeResource = $this->dbTable;
				$this->translations = $this->dbTable;
				$this->validatorName = $this->modelName.'Request';
				$this->compactInstace = Str::snake($this->modelName);
				$this->modelInstace = "$".$this->compactInstace;
				$this->permissions = $this->dbTable;
				$this->templateDir = str_replace('\\', '/', $this->getDirectoryName($this->dbTable));
				$this->templatePath = $this->laravel['path.resources'].'/views/'.$this->templateDir."/";
				if(!$this->arrFields->isEmpty()) {
					$result = true;
				} else {
					$this->error('The specified table does not exist in current database.');
				}
			} else {
				$this->error('The name "'.$this->getNameInput().'" is reserved by PHP.');
			}
		}

		return $result;
	}

	/**
	 * [getStubContent Get stub file content and replace the parameters with values]
	 * @param  [string] $template   [stub file resource]
	 * @param  array  $addSearch  [additional search parameters]
	 * @param  array  $addReplace [additional replace values]
	 * @return [string]             [stub content with values]
	 */
	protected function getStubContent($template, $addSearch = [], $addReplace = [])
	{
		$stub = $this->files->get($template);
		$search = [
			'{{ modelName }}', 
			'{{ modelInstace }}', 
			'{{ validatorName }}', 
			'{{ datatableName }}', 
			'{{ routeResource }}', 
			'{{ translations }}', 
			'{{ templateDir }}',
			'{{ table }}',
			'{{ permissions }}',
		];
		$replace = [
			$this->modelName,
			$this->modelInstace,
			$this->validatorName,
			$this->datatableName,
			$this->routeResource,
			$this->translations,
			$this->templateDir,
			$this->dbTable,
			$this->permissions,
		];
		$search = array_merge($search, $addSearch);
		$replace = array_merge($replace, $addReplace);
		return str_replace($search, $replace, $stub);
	}


#region database
	/**
	 * [getTable Check if the table name was specified in the command option, if not then converts the model name into camel case]
	 * @return [type] [description]
	 */
	protected function getTablename()
	{
		$result = "";
		if($this->option('table') != false)
			$result = $this->option('table');
		else {
			$result = Str::plural(strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $this->modelName)));
		}
		return $result;
	}

	/**
	 * [getTablefields Retreive an array of all the columns in the table]
	 * @param  [type] $table [description]
	 * @return [type]        [description]
	 */
	protected function getTablefields($table = null)
	{
		//return \Schema::getColumnListing($this->dbTable);
		return DB::connection('mysql_information')
			->table('COLUMNS')
			->where(['TABLE_SCHEMA' => env('DB_DATABASE'), 'TABLE_NAME' => $table ?? $this->dbTable])
			->get();
	}

	protected function getTableConstraints()
	{
		return DB::connection('mysql_information')
			->table('REFERENTIAL_CONSTRAINTS')
			->where(['CONSTRAINT_SCHEMA' => env('DB_DATABASE')])
			->get();
	}

	protected function getConstraints()
	{
		$belongsTo = []; //Array to stack the fields for the "belongs to" relation
		$hasMany = []; //Array to stack the fields for the "has many" relation
		$fkField = Str::singular($this->dbTable)."_id";

		foreach ($this->getTableConstraints() as $key => $constraint) {
			//Get all belongs to relations
			//if($constraint->TABLE_NAME == $this->dbTable && $constraint->CONSTRAINT_TYPE == "FOREIGN KEY") {
			if($constraint->TABLE_NAME == $this->dbTable) {
				$belongsTo[] = [
					"field" => str_replace([$constraint->TABLE_NAME."_", "_foreign"], ["", ""], $constraint->CONSTRAINT_NAME),
					"tablename" => $constraint->REFERENCED_TABLE_NAME,
				];
			}

			//Get all has many relations
			if($constraint->REFERENCED_TABLE_NAME == $this->dbTable) {
			//if(strpos($constraint->CONSTRAINT_NAME, $fkField) !== false) {
				$hasMany[] = [
					"field" => str_replace([$constraint->TABLE_NAME."_", "_foreign"], ["", ""], $constraint->CONSTRAINT_NAME),
					"tablename" => $constraint->TABLE_NAME,
				];
			}
		}
		sort($belongsTo);
		sort($hasMany);

		return compact('belongsTo', 'hasMany');
	}

	protected function getAllBelongstoRelations()
	{
		$excludedFields = ["created_by", "updated_by"];
		//Get all table relationships
		$constraints = $this->getConstraints();
		$result = $constraints["belongsTo"] ?? [];
		
		//Remove relations we don't need catalogs
		foreach ($result as $key => $relation) {
			if(in_array($relation["field"], $excludedFields)) {
				unset($result[$key]);
			}
		}

		return $result;
	}

	protected function getDisplayField($tablename)
	{
		$result = null;
		if($tablename != null) {
			$fields = $this->getTablefields($tablename);
			foreach ($fields as $key => $field) {
				if ($field->DATA_TYPE == "varchar") {
					$result = $field->COLUMN_NAME;
					break;
				}
			}
		}
		return $result;
	}
#end region

	protected function backupFile($file)
	{
		if($this->backup) {
			//Check if file exist and make a backup
			if($this->files->exists($file)) {
				$oldFile = $this->files->get($file);
				$this->files->put($file."_bk".date("YmdHis"), $oldFile);
			}
		}
	}

	protected function getDirectoryName($param)
	{
		return str_replace("_", "-", $param);
	}

	protected function strTableToModel($tablename)
	{
		return Str::studly(Str::singular(strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $tablename))));
	}
}
