<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;

class CrudMakerTranslationCommand extends CrudMakerBaseCommand
{
	protected $signature = 'crudmaker:translation 
		{name : Entity (Example: "User", "Student").} 
		{--table= : Define a database table in case the name is different from model name.}
		{--no-warning}';
	protected $description = "Generate model with fillable fields and relations";

	public function handle()
	{
		if($this->validateInputData()) {
			$this->generateTranslations();
		}
	}

	private function generateTranslations()
	{
		$file = base_path().'/lang/'.config('app.locale').'/'.str_replace('\\', '/', $this->translations).'.php';
		$this->backupFile($file);
		$this->makeDirectory($file);
		$this->files->put($file, $this->getTranslations());
		$this->info('Lang file created successfully.');

	}

	private function getLangData()
	{
		$defaultTranslations = [
			"es" => [
				"titles" => [
					"title_index" => $this->translations,
					"title_add" => "Agregar ".Str::singular($this->translations),
					"title_show" => "Ver ".Str::singular($this->translations),
					"title_edit" => "Modificar ".Str::singular($this->translations),
					"title_delete" => "Eliminar ".Str::singular($this->translations),
				],
				"fields" => [
					"name" => "Nombre",
					"last_name" => "Apellido paterno",
					"mother_last_name" => "Apellido materno",
					"background_color" => "Color de fondo",
					"text_color" => "Color de texto",
					"color" => "Color",
					"number" => "Número",
					"description" => "Descripción",
					"notes" => "Notas",
					"created_by" => "Creado por",
					"updated_by" => "Modificado por",
					"created_at" => "Fecha creado",
					"updated_at" => "Fecha modificado",
				],
				"action_messages" => [
					"confirm_delete" => "Se borrará ".Str::singular($this->translations)." de la base de datos. ¿Desea continuar?",
					"Successfully created" => Str::singular($this->translations)." creado correctamente",
					"Successfully updated" => Str::singular($this->translations)." modificado correctamente",
					"Successfully deleted" => Str::singular($this->translations)." eliminado correctamente",
					"delete_error_message" => "Error al intentar eliminar ".Str::singular($this->translations)." de la base de datos",
					"delete_error_message_constraint" => "No se puede eliminar ".Str::singular($this->translations).", hay tablas que dependen de este",
				]
			]
		];

		return $defaultTranslations[config('app.locale')] ?? null;
	}

	private function getTranslations()
	{
		$langData = $this->getLangData();
		
		//Add titles translations
		$result = '<?php
return [
	//Titles';
		foreach ($langData["titles"] as $key => $ct) {
			$result .= '
	"'.$key.'" => "'.$ct.'",';
		}

		//Add fields translations
		$result .= '

	//Fields';
		foreach ($this->arrFields as $key => $field) {
			$ct = $langData["fields"][$field->COLUMN_NAME] ?? $field->COLUMN_NAME;
			$result .= '
	"'.$field->COLUMN_NAME.'" => "'.$ct.'",';
		}


		//Add messages translations
		if($langData != null) {
			$result .= '

	//Action messages';
			foreach ($langData["action_messages"] as $key => $ct) {
				$result .= '
	"'.$key.'" => "'.$ct.'",';
			}
			$result .= '
];';
		}

		return $result;
	}
}
