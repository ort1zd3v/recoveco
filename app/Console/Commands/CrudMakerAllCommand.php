<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;

class CrudMakerAllCommand extends CrudMakerBaseCommand
{
	protected $signature = 'crudmaker:all 
		{name : Entity (Example: "User", "Student").} 
		{--table= : Define a database table in case the name is different from model name.}
		{--no-warning : If you do not want the system asks you for replace the files}';
	protected $description = "Generate model with fillable fields and relations";

	public function handle()
	{
		if($this->validateInputData()) {
			$params = ['name' => $this->getNameInput(), '--table' => $this->dbTable, '--no-warning' => 'true'];
			$this->call('crudmaker:model', $params);
			$this->call('crudmaker:request', $params);
			$this->call('crudmaker:datatable', $params);
			$this->call('crudmaker:controller', $params);
			$this->call('crudmaker:view', $params);
			$this->call('crudmaker:translation', $params);
		}
	}
}
