@extends('layouts.app', [
	'title' => __('starting_founds.title_add'), 
])
@section('content')
<div class="d-flex align-items-center justify-content-center">
	<div class="w-50 card p-3 text-center">
		<h1>Fondo de caja</h1>
		<p>Para entrar a punto de venta, es necesario cerrar el día o esperar al día siguiente.</p>
		
		<button type="button" class="btn btn-primary font-size-16 p-3" onclick=window.location="{{ route('starting_founds.show', $day->id) }}">
			Cerrar día
		</button>
	</div>
</div>
@endsection