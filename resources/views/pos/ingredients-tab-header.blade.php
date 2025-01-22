<li class="nav-item me-2" role="presentation">
	<button class="nav-link font-size-22 text-gray {{ ($active ?? false) ? 'active' : '' }}" 
		id="{{ str_replace(" ", '-', $tab) }}-tab" data-bs-toggle="tab" 
		data-bs-target="#{{ str_replace(" ", '-', $tab) }}"
		data-name="{{ $tab }}" type="button" role="tab">
		{{ $tab }}
	</button>
</li>