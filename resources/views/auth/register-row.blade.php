<div class="row">
	<div class="col">
		<label for="{{ $name }}" class="col-form-label text-lg-right text-secondary">
			@lang('auth.'.$name)
		</label>
	</div>
</div>
<div class="row mb-4">
	<div class="col">
		<input id="{{ $name }}" type="{{ $type }}" class="form-control input-login @error($name) is-invalid @enderror input" 
			name="{{ $name }}" required autocomplete="{{ $name }}" placeholder="@lang('auth.'.$name)" value="{{ old($name) }}">

		@error($name)
			<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
</div>