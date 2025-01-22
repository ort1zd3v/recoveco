@if(session()->has('message'))
	<div class="alert alert-info dismissible">
		<button type="button" class="btn btn-default" data-bs-dismiss="alert" aria-label="Close">
			<i class="fa-solid fa-xmark"></i>
		</button>
		{!! session()->get('message') !!}
	</div>
@endif
@if(session()->has('error'))
	<div class="alert alert-danger dismissible">
		<button type="button" class="btn btn-default" data-bs-dismiss="alert" aria-label="Close">
			<i class="fa-solid fa-xmark"></i>
		</button>
		{!! session()->get('error') !!}
	</div>
@endif
@if ($errors->any())
	<div class="alert alert-danger dismissible">
		<button type="button" class="btn btn-default" data-bs-dismiss="alert" aria-label="Close">
			<i class="fa-solid fa-xmark"></i>
		</button>
		<ul>
			@foreach ($errors->all() as $error)
				<li>{!! $error !!}</li>
			@endforeach
		</ul>
	</div>
@endif