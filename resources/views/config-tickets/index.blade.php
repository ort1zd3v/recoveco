@extends('layouts.app')
@section('content')
	<h1>Configuración de ticket</h1>
	<div class="row">
		<div class="col-md-7">
			<div class="card p-3">
				{{ Form::open(['id' => 'config_ticket-update', 'route' => ['config_tickets.update', 1], 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
					@method('PUT')
					@include('config-tickets.fields')

					<div class="d-flex justify-content-end">
						<button type="submit" class="btn btn-primary">Actualizar</button>
					</div>
				{{ Form::close() }}
			</div>
		</div>
		<div class="col-md-5">
			<div class="preview">
				@include('config-tickets.ticket_preview')
			</div>
		</div>
	</div>
@endsection

@push('styles')
	<style>
		.preview {
			position: fixed;
			max-width: 380px;
			width: 100%;
		}

		@media only screen and (max-width: 992px) {
			.preview {
				position: relative;
				top: 0%;
				left: 0%;
				transform: translate(0%, 0%);
			}
		}
	</style>
@endpush


