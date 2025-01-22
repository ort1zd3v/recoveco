@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="col-12">
			<input type="hidden" id="allowAdd" value="{{ $allowAdd ?? false }}">
			<input type="hidden" id="allowEdit" value="{{ $allowEdit ?? false }}">
			<input type="hidden" id="entity" value="{{ $entity }}">
			<input type="hidden" id="form" value="{{ $form }}">
			@yield('data')

			<div class="row pt-4">
				<div class="col-12 col-md-10">
					<h3 class="pl-3">{!! $title !!}</h3>
				</div>
				{{-- <div class="col-12 col-md-2 text-end pr-4">
					@if($allowAdd ?? false)
						@php $rParams = ($routeParams ?? []); @endphp
						@if($source ?? false)
							@php $rParams = $rParams + ["source" => $source]; @endphp
						@endif
						<a href="{{ route($entity.'.create', $rParams) }}">
							<button type="button" class="btn btn-default button-add" title="{{ __('create') }}">
								<i class="fa fa-plus add"></i>
							</button>
						</a>
					@endif
				</div> --}}
			</div>
			{{-- <hr class="line"> --}}
			<div class="row ">
				<div class="col-12 px-4">
					@yield('filters')
				</div>
			</div>
			<div id="message" class="row  flex-shrink-0 flex-row ">
				<div class="col-12">
					<div class="message-container"></div>
					@include('crud-maker.components.session-alerts')
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					@yield('datatable')
				</div>
			</div>
		</div>
	</div>

	@include('crud-maker.components.modal-delete')
@endsection
@push('scripts')
	{{ $dataTable->scripts() }}
	@stack('customScripts')
@endpush