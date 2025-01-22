<div class="modal" id="deleterowModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		{{ Form::open(['method' => 'delete', 'name' => 'deleterowForm', 'id' => 'deleterowForm']) }}
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					@lang('delete')
				</h5>
				<button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="mdi mdi-window-close icon-edit font-size-18"></i></span>
				</button>
			</div>
			<div class="modal-body">
				<div class="alert alert-warning">
					<span><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
					<span class="alert-message">
						@lang('Are you sure you want to delete this row?')
					</span>
				</div>
			</div>
			@if($footer ?? true)
				<div class="modal-footer">
					{{ Form::button(__("Cancel"), ["class" => "btn btn-danger", "data-bs-dismiss" => "modal"]) }}
					{{ Form::button(__("delete"), ["class" => "btn btn-primary button-delete"]) }}
				</div>
			@endif
		</div>
		{{ Form::close() }}
	</div>
</div>