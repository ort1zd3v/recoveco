@extends('layouts.app')

@section('content')
	<input type="hidden" id="allowEdit" value="{{ $allowEdit }}">
	<input type="hidden" id="entity" value="{{ $entity }}">
	<input type="hidden" id="form" value="{{ $form }}">
	@yield('data')

	<ul class="accordion">
		@foreach($tabs as $key => $tab)
		<li id="{{ $tab["id"] }}" class="accordion-item 
			{!! isset($tab['disabled']) ? $tab['disabled'] == true ? '' : 'clickeable-item' : 'clickeable-item' !!} 
			{{ $key == 0 ? 'active' : '' }}" 
			>
			<div class="accordion-header">
				<h2>{{ $tab["label"] }}</h2>
			</div>
			<div class="accordion-content">
				@if($key == 0)
					<div class="w-100 pb-4">
						@include('crud-maker.components.session-alerts')
						<div class="message-container"></div>
						<div class="row">
							<h3 class="pl-3">{{ $tab["label"] }}</h3>
							@if($allowAdd)
								<button type="button" class="btn btn-primary button-add" title="{{ __('create') }}" onclick="addRow()">
									<i class="fa fa-plus add"></i>
								</button>
							@endif
						</div>
						<hr class="line">
						@yield('datatable')
					</div>
				@endif
			</div>
		</li>
		@endforeach
	</ul>

	<div id="tabsContainer">
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item">
				<a class="nav-link active icons" id="table-tab" data-toggle="tab" href="#tableTabContent" role="tab" aria-controls="table" aria-selected="true" title="{{ __('Table') }}"><i class="fas fa-table"></i></a>
			</li>
			<li class="nav-item">
				<a class="nav-link icons" id="grid-tab" data-toggle="tab" href="#gridTabContent" role="tab" aria-controls="grid" aria-selected="false" title="{{ __('Grid') }}"><i class="fas fa-th-large"></i></a>
			</li>
		</ul>
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="tableTabContent" role="tabpanel" aria-labelledby="table-tab"></div>
			<div class="tab-pane fade" id="gridTabContent" role="tabpanel" aria-labelledby="grid-tab">
				<div class="grid-content"></div>
			</div>
		</div>
	</div>

	@include('crud-maker.components.modal-delete')
@endsection
@push('styles')
	<link href="{{ asset('css/crud_maker/datatables_styles.css') }}" rel="stylesheet">
@endpush
@push('scripts')
	{{ $dataTable->scripts() }}
	<script src="{{ asset('js/lang.js') }}"></script>
	<script src="{{ asset('js/crud_maker/DatatablesGrid.js') }}"></script>
	<script src="{{ asset('js/crud_maker/functions.js') }}"></script>
	@stack('customScripts')
@endpush