<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;

class CrudMakerViewCommand extends CrudMakerBaseCommand
{
	protected $signature = 'crudmaker:view 
		{name : Entity (Example: "User", "Student").} 
		{--table= : Define a database table in case the name is different from model name.}
		{--view= : Define specific view you want to generate (index, show, create, edit) }
		{--no-warning}';
	protected $description = "Generate model with fillable fields and relations";

	public function handle()
	{
		if($this->validateInputData()) {
			$this->makeDirectory($this->templatePath);
			
			//If user didn't specified view then all are generated
			if(!$this->option('view')) {
				foreach (["index", "show", "create", "edit"] as $key => $view) {
					$this->createView($view);
				}
			} else {
				$this->createView($this->option('view'));
			}
		}
	}

	/**
	 * [createViews Create the CRUD resource files (index, create, show, edit)]
	 * @return [type] [description]
	 */
	private $fieldsGenerated = false;
	private function createView($param)
	{
		$file = $this->templatePath.$param.".blade.php";
		$this->backupFile($file);
		$this->makeDirectory($file);
		$template = $this->stubDir."views/".$param.".stub";

		$content = call_user_func([$this, "get".Str::studly($param)."Content"], $template);

		$this->files->put($file, $content);
		$this->info('View '.$param.' created successfully.');

		if(in_array($param, ["create", "edit"]) && !$this->fieldsGenerated) {
			//Call getFieldsContent
			$this->createView("fields");
			$this->fieldsGenerated = true;
		}
	}


#region getContent
	private function getIndexContent($template)
	{
		/** Convert array fields into an string to replace in the template */
		$strFields = "";
		foreach ($this->arrFields as $key => $field) {
			if($field->COLUMN_NAME != "id")
				$strFields .= "'".$field->COLUMN_NAME."', ";
		}
		$strFields = substr($strFields, 0, -2);
		/**  */
		
		$search = ['{{ form }}', '{{ modelName }}', '{{ fields }}'];
		$replace = [lcfirst($this->modelName), $this->modelName, $strFields];
		$result = $this->getStubContent($template, $search, $replace);

		return $result;
	}

	private function getShowContent($template)
	{
		/** Generate the content for show file */
		$content = '';
		foreach ($this->arrFields as $key => $field) {
			$content .= '
					<div class="row">
						<div class="col-sm-4 offset-sm-1 text-end">@lang(\''.$this->translations.'.'.$field->COLUMN_NAME.'\')</div>
						<div class="col-sm-6">{{ '.$this->modelInstace.'->'.$field->COLUMN_NAME.' }}</div>
					</div>';
		}
		/**  */

		/** Get stub file content and replace params with real values */
		$search = ['{{ content }}'];
		$replace = [$content];
		$result = $this->getStubContent($template, $search, $replace);

		return $result;
	}

	private function getCreateContent($template)
	{
		$content = '@include("'.$this->templateDir.'.fields")';
		/** Get stub file content and replace params with real values */
		$search = ['{{ content }}', '{{ form }}', '{{ route }}'];
		$replace = [$content, lcfirst($this->modelName), $this->routeResource];
		$result = $this->getStubContent($template, $search, $replace);

		return $result;
	}

	private function getEditContent($template)
	{
		$content = '@include("'.$this->templateDir.'.fields", ["isEdit" => true])';
		/** Get stub file content and replace params with real values */
		$search = ['{{ content }}', '{{ form }}', '{{ route }}'];
		$replace = [$content, lcfirst($this->modelName), $this->routeResource];
		$result = $this->getStubContent($template, $search, $replace);

		return $result;
	}

	private function getFieldsContent($template)
	{
		$content = '';
		foreach ($this->arrFields as $key => $field) {
			//Exclude from generating
			if(!in_array($field->COLUMN_NAME, $this->ignoreColumns)) {
				$params = [
					"name" => '"'.$field->COLUMN_NAME.'"',
					"id" => '"'.$field->COLUMN_NAME.'"',
					"class" => '"form-control"',
					"entity" => '"'.$this->translations.'"',
					"type" => '"text"',
					"defaultValue" => 'old("'.$field->COLUMN_NAME.'") ?? ('.$this->modelInstace.'->'.$field->COLUMN_NAME.' ?? "")',
				];
				if($field->IS_NULLABLE == "NO")
					$params["required"] = '"true"';
				
				//If the column should have a relation
				if (strpos($field->COLUMN_NAME, "_id")) {
					$tablename = $this->getConstraintTable($field->COLUMN_NAME);
					$displayField = $this->getDisplayField($tablename);

					//Si la tabla relacionada tiene campo descripción se agrega como select
					//De lo contrario se agrega como autocomplete
					if($displayField == "name") {
						$params["type"] = '"select"';
						$params["class"] = '"form-select"';
						$params["elements"] = '$'.Str::plural(Str::camel($tablename)).' ?? []';
					} else {
						$arrName = explode("_", $field->COLUMN_NAME);
						$params["name"] = '"'.$arrName[0].'_input"';
						$params["id"] = '"'.$arrName[0].'_input"';
						$params["type"] = '"input-autocomplete"';
						$params["class"] = '"form-control input-autocomplete"';
						$params["data-source"] = '"'.$tablename.'/getbyparam"';
						$params["data-hidden-id"] = '"'.$field->COLUMN_NAME.'"';
						$params["data-hidden-value"] = $params["defaultValue"];
						$params["defaultValue"] =  'old('.$params["name"].') ?? ('.$this->modelInstace.'->'.$arrName[0].'_input ?? "")';
						$params["translations"] = '"'.$this->translations.'.'.$field->COLUMN_NAME.'"';
					}
				} else if($field->COLUMN_NAME == "notes") {
					$params["type"] = '"textarea"';
				} else {
					$params["type"] = '"text"';
				}

				$content .= "@include(\"crud-maker.components.form-row\", [\"params\" => [\n\t[";
				foreach ($params as $key => $value) {
					$content .= "\n\t\t\"".$key.'" => '.$value.',';
				}
				$content .= "\n\t]\n]])\n";
			}
		}

		/** Get stub file content and replace params with real values */
		$search = ['{{ content }}'];
		$replace = [$content];
		$result = $this->getStubContent($template, $search, $replace);
		return $result;
	}

	private function getConstraintTable($param)
	{
		$result = '';
		foreach ($this->getAllBelongstoRelations() as $key => $relation) {
			if($relation["field"] == $param) {
				$result = $relation["tablename"];
				break;
			}
		}
		return $result;
	}
#endregion getContent
}
