<nav>
	<div class="nav nav-tabs" id="nav-tab" role="tablist">
		@foreach($permissionModules as $key => $permissionModule)
				<button class="nav-link {{ $key == 0 ? 'active' : '' }}" id="nav-home-tab" data-bs-toggle="tab" 
					data-bs-target="#permissionsSection{{ $permissionModule->id }}" 
					type="button" role="tab" aria-controls="nav-home" aria-selected="true">
					@if($permissionModule->module_type_id == 1)
						{{ __('permissions.'.$permissionModule->name) }}
					@else
						{{ __($permissionModule->name.'.title_index') }}
					@endif
				</button>
		@endforeach
	</div>
</nav>

<div class="tab-content m-4" id="nav-tabContent">
@foreach($permissionModules as $key => $permissionModule)

	<div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="permissionsSection{{ $permissionModule->id }}" role="tabpanel" aria-labelledby="nav-profile-tab">
		<div class="row">
			<div class="col-12 text-left">
				<input type="checkbox" id="section-{{ $permissionModule->id }}" class="checkSection" 
						data-parent="{{ ($permissionModule->module_id != null ? 'section-'.$permissionModule->module_id : '0') }}" >
				<label for="section-{{ $permissionModule->id }}">
						<h6 class="card-title">{{ __('Select all') }}</h6>
				</label>
			</div>
		</div>

		<div class="row">
			@if($permissionModule->module_type_id == 1)
				@if(isset($permissionModule->modules))
					@include("roles.permissions-tabs", ["permissionModules" => $permissionModule->modules])
				@endif
			@else
				<div class="col-12 ms-4">
				@foreach ($permissionModule->permissions as $key => $permission)
					<input name ="permissions[{{ $permission->id }}]" type="checkbox" id="permission-{{ $permission->id }}" class="checkPermission" data-parent="section-{{ $permissionModule->id }}" 
					{{ isset($permissions[$permission->id]) || isset($permissionsParent[$permission->id]) ? "checked" : "" }}
					{{ isset($permissionsParent[$permission->id]) ? "disabled" : "" }}
					>
						<label for="permission-{{ $permission->id }}">
							<span title="{{ $permission->permissionFunction->name }}">
								{{ __("permissions.".$permission->permissionFunction->name) }}
							</span>
						</label>
						<br>
				@endforeach
				</div>
			@endif
		</div>
	</div>
@endforeach
</div>