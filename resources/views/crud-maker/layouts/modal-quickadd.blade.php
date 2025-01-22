<div class="modal {{ $params["entity"] ?? 'modal' }}-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					{{ __(($params["translations"] ?? $params["entity"]).'.title_add') }}
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				{{ Form::open(['id' => $params["entity"].'-quickadd']) }}
				<div class="message-container"></div>
				@include( ($params["resource"] ?? $params["entity"]) .".fields")
				{{ Form::close() }}
			</div>
			<div class="modal-footer">
				{{ Form::button(__("Save"), ["class" => "btn btn-primary", "onclick" => "saveQuickAdd('".base64_encode(json_encode($params))."')"]) }}
				{{ Form::button(__("Cancel"), ["class" => "btn btn-secondary", "data-dismiss" => "modal"]) }}
			</div>
		</div>
	</div>
</div>