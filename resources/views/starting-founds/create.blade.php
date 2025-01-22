@extends('layouts.app', [
	'title' => __('starting_founds.title_add'), 
])

@section('content')
	<div class="d-flex align-items-center justify-content-center">
		<div class="w-50 card p-3">
			{{ Form::open(['id' => 'starting-founds-init-day', 'route' => "starting_founds.store", 'method' => 'POST']) }}
				<h1 class="text-center">Iniciar día</h1>
				<div class="d-flex gap-2 justify-content-center">
					@include("crud-maker.components.form-row", ["params" => [
						[
							"name" => "amount",
							"id" => "amount",
							"class" => "form-control",
							"entity" => "starting_founds",
							"type" => "text",
							"defaultValue" => old("amount") ?? ($starting_found->amount ?? ""),
							"required" => "true",
						]
					]])
					@include("crud-maker.components.form-row", ["params" => [
						[
							"name" => "initial_user_id",
							"id" => "initial_user_id",
							"class" => "form-select",
							"entity" => "starting_founds",
							"type" => "select",
							"elements" => $users,
							"defaultValue" => auth()->id() ?? "",
							"required" => "true",
						]
					]])
				</div>
				<div class="d-flex justify-content-center">
					<button type="submit" class="btn btn-primary">Iniciar día</button>
				</div>
			{{ Form::close() }}
		</div>
	</div>
@endsection