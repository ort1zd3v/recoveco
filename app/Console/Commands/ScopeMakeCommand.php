<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class ScopeMakeCommand extends GeneratorCommand
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $name = 'make:scope';
	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new scope';
	/**
	 * Get the stub file for the generator.
	 *
	 * @return string
	 */
	protected function getStub()
	{
		return __DIR__.'/stubs/scope.stub';
	}
	/**
	 * Get the default namespace for the class.
	 *
	 * @param  string  $rootNamespace
	 * @return string
	 */
	protected function getDefaultNamespace($rootNamespace)
	{
		return $rootNamespace.'\Scopes';
	}
}
