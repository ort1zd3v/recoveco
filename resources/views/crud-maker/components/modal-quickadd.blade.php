@php $model = ${Str::singular($params["entity"])}; @endphp
<div class="modal {{ $params["entity"] ?? 'modal' }}-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					{{ __(($params["translations"] ?? $params["entity"]).'.title_'.($model === null ? 'add' : 'edit')) }}
				</h5>
				<button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				@if($model === null)
					{{ Form::open(['id' => $params["entity"].'-quickmodal', 'route' => $params["entity"].'.store']) }}
				@else
					{{ Form::open(['id' => $params["entity"].'-quickmodal', 'route' => [$params["entity"].'.update', $model->id], 'method' => 'POST']) }}
					@method('PUT')
					<input type="hidden" name="id" value="{{ $model->id }}">
				@endif
				<div class="message-container"></div>
				@include(($params['resource'] ?? str_replace('_', '-', $params['entity'])) . '.fields')
				{{ Form::close() }}
			</div>
			<div class="modal-footer">
				{{ Form::button(__("Save"), ["class" => "btn btn-primary", "onclick" => "saveQuickAdd('".base64_encode(json_encode($params))."')"]) }}
				{{ Form::button(__("Cancel"), ["class" => "btn btn-secondary", "data-bs-dismiss" => "modal"]) }}
			</div>
		</div>
	</div>
</div>