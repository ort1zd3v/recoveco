@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<input type="hidden" id="route" value="{{ $entity }}" />
			<div class="card card-info">
				<div class="card-header">
					<div class="row">
						<div class="col-12 card-title">{{ __($entity.'.title_add') }}</div>
					</div>
				</div>
				{{ Form::open(['id' => $entity.'-create', 'route' => $entity.".store", 'method' => 'POST']) }}
					<div class="card-body">
						<button type="button" class="btn btn-default" title="Agregar fila" onclick="addRow()">
							<i class="fa fa-plus add"></i>
						</button>
						<div class="table">
							<div class="table-header">
								<div class="row">
								@foreach($fields as $field)
									<div class="col-12 col-md-{{ $field["cols"] }}">
										{{ __($entity.".".$field["name"]) }}
									</div>
								@endforeach
									<div class="col-12 col-md">{{ __('actions') }}</div>
								</div>
							</div>
							<div class="table-body">
								@for($i = 1; $i <= 5; $i++)
									@php $rowNumber = $i; @endphp
									@include('components.crud.addrow', [
										"fields" => $fields,
										"rowNumber" => $rowNumber,
										"entity" => $entity,
									])
								@endfor
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-sm-10 col-lg-4 offset-lg-8 text-end">
								<button type="button" class="btn btn-primary" onclick="saveAll()">
									{{ __('Save all') }}
								</button>
								<a href="{{ route($entity.'.index') }}">
									<button type="button" class="btn btn-secondary">{{ __('Cancel') }}</button>
								</a>
							</div>
						</div>
					</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>
@endsection
@push('scripts')
	<script src="{{ asset('js/crud_maker/multirow_functions.js') }}"></script>
@endpush