<div class="modal" id="{{ $id ?? "modal" }}" tabindex="-1" role="dialog">
	<div class="modal-dialog {{ $class ?? "" }}" role="document">
		@if(@isset($form)) {{ Form::open($form) }} @endif
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					{{ $title ?? "Modal" }}
				</h5>
				<button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				@yield('modalContent')
			</div>
			@if($footer ?? true)
				<div class="modal-footer">
					@yield('modalFooter')
				</div>
			@endif
		</div>
		@if(@isset($form)) {{ Form::close() }} @endif
	</div>
</div>