<li class="nav-item me-1 d-none" role="presentation">
	<button class="nav-link font-size-16 text-gray {{ ($active ?? false) ? 'active' : '' }}" 
		id="{{ str_replace(" ", '-', $name) }}-tab" data-bs-toggle="tab" 
		data-bs-target="#{{ str_replace(" ", '-', $name) }}"
		type="button" role="tab">
		{{ $name }}
	</button>
</li>