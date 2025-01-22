<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<br>
			<div class="card card-info">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-12 col-md-6 card-title">{{ __('roles.title_permissions_edit') }}</div>
					</div>
				</div>

				{{ Form::open(['id' => 'role-edit-permissions']) }}
					@include('components.displayerrors')
					{{ Form::hidden("role_id", $role->id) }}
					<div class="card-body permissionsContainer">
						{!! showPermissions($permissionModules, $role->permissions) !!}
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-sm-10 col-lg-4 offset-lg-8 text-right">
								<button type="submit" class="btn btn-primary">{{ __('save') }}</button>
							</div>
						</div>
					</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>
@php
function showPermissions($permissionModules, $rPermissions) {
	$permissions = getPermissions($permissionModules, $rPermissions);
	return $permissions["result"];
}
function getPermissions($permissionModules, $rPermissions)
{
	$result = '';
	$checkModule = true;
	foreach ($permissionModules as $key => $permissionModule) {
		if($permissionModule->module_type_id == 1) {
			if(isset($permissionModule->modules)) {
				$sub = getPermissions($permissionModule->modules, $rPermissions);

				$result .= '<div class="modulesContainer">
					<div class="sectionTitle">
						<input type="checkbox" id="section-'.$permissionModule->id.'" 
							class="checkSection" 
							data-parent="'.($permissionModule->module_id != null ? 'section-'.$permissionModule->module_id : '0').'" 
							'.($sub["checkModule"] ? 'checked' : '').'>
						<label for="section-'.$permissionModule->id.'" class="btn btn-primary">
							<h3>'.$permissionModule->name.'</h3>
						</label>
					</div>
					<div class="sectionContent">
						'.$sub["result"].'
					</div>
				</div>';
			}
		} else {
			$pContent = '';
			$cc = 0;
			foreach ($permissionModule->permissions as $key => $permission) {
				$checkPermission = false;
				foreach ($rPermissions as $key => $rPermission) {
					if($permission->id === $rPermission->id) {
						$checkPermission = true;
						break;
					}
				}
				if($checkPermission)
					$cc++;
				$pContent .= '
					<input name ="permissions['.$permission->id.']" type="checkbox" id="permission-'.$permission->id.'" 
						class="checkPermission" 
						data-parent="section-'.$permissionModule->id.'" 
						'.($checkPermission ? 'checked' : '').'>
					<label for="permission-'.$permission->id.'">'.
						$permissionModule->name.'.'.$permission->permissionFunction->name
					.'</label><br />';
			}
			//Si todos los permisos de la sección (vista) están seleccionados, ponemos checkSection true para seleccionar el checkbox de la sección
			$checkSection = false;
			if($cc == $permissionModule->permissions->count()) {
				$checkSection = true;
			}

			//Para cada iteración de cada sección (vista) revisar si está seleccionada, si todas las secciones están seleccionadas seleccionamos el módulo
			if(!$checkSection)
				$checkModule = false;

			$result .= '
			<div class="moduleContainer">
				<div class="sectionTitle">
					<input type="checkbox" id="section-'.$permissionModule->id.'" 
						class="checkSection" 
						data-parent="'.($permissionModule->module_id != null ? 'section-'.$permissionModule->module_id : '0').'" 
						'.($checkSection ? 'checked' : '').'>
					<label for="section-'.$permissionModule->id.'" class="btn btn-primary">
						<h4>'.$permissionModule->name.'</h4>
					</label>
				</div>
				<div class="sectionContent">'.$pContent.'</div>
			</div>';
		}
	}

	return compact('result', 'checkModule');
}
@endphp