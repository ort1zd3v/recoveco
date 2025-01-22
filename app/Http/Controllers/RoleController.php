<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\PermissionModule;
use App\Models\PermissionPermissionRole;
use App\Models\PermissionPermissionUser;

use App\Http\Requests\RoleRequest;
use App\DataTables\RoleDataTable;
use Illuminate\Http\Request;

class RoleController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//Consultar permiso para botón de agregar
		//$allowAdd = true;
		$allowAdd = auth()->user()->hasPermissions("roles.create");
		$allowEdit = auth()->user()->hasPermissions("roles.edit");
		return (new RoleDataTable())->render('roles.index', compact('allowAdd', 'allowEdit'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		
		return view('roles.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(RoleRequest $request)
	{
		$status = true;
		$role = null;
		$params = array_merge($request->all(), [
			'created_by' => auth()->id(),
			'updated_by' => auth()->id(),
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		try {
			$role = Role::create($params);
			$message = __('roles.Successfully created');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'roles');
		}
		return $this->getResponse($status, $message, $role);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Role  $role
	 * @return \Illuminate\Http\Response
	 */
	public function show(Role $role)
	{
		return view('roles.show', compact('role'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Role  $role
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Role $role)
	{
		
		return view('roles.edit', compact('role'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Role  $role
	 * @return \Illuminate\Http\Response
	 */
	public function update(RoleRequest $request, Role $role)
	{
		$status = true;
		$params = array_merge($request->all(), [
			'updated_by' => auth()->id(),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		try {
			$role->update($params);
			$message = __('roles.Successfully updated');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'roles');
		}
		return $this->getResponse($status, $message, $role);
	}
	
	public function destroy(Role $role)
	{
		$status = true;
		try {
			PermissionPermissionRole::where("role_id", $role->id)->delete();
			$role->delete();
			$message = __('roles.Successfully deleted');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'roles');
		}
		return $this->getResponse($status, $message);
	}

	public function getQuickModalContent(Role $role = null)
	{
		$params = request("params");
		return response()->json(view('crud-maker.components.modal-quickadd', compact('params', 'role'))->render());
	}

	public function permissions(Role $role)
	{
		$permissionModules = (new PermissionModule)->permissionsByModule();
		$permissions = $role->permissionsArray();
		return view('roles.permissions', compact('role', 'permissionModules', 'permissions'));
	}

	public function savePermissions(Request $request, Role $role)
	{
		if(isset($request["permissions"])) {
			//Eliminar todos los permisos que tenga el rol y volver a crearlos
			PermissionPermissionRole::where("role_id", $role->id)->delete();
			$pArray = [];
			foreach ($request["permissions"] as $key => $permission) {
				PermissionPermissionRole::create([
					'permission_id' => $key, 
					'role_id' => $role->id, 
					'created_at' => date("Y-m-d H:i:s"), 
					'updated_at' => date("Y-m-d H:i:s"),
				]);
				$pArray[] = $key;
			}

			//Buscar si los permisos asignados al rol se sobreponen a los permisos asignados a los usuarios con este rol
			//Si se encuentran se eliminan
			//$role = Role::find($data["role_id"]);
			PermissionPermissionUser::whereIn('user_id', $role->users->pluck("id"))->whereIn('permission_id', $pArray)->delete();
		}

		if($request->wantsJson()) {
			$result = response()->json(["message" => __('roles.Successfully saved permissions'), "data" => $role], 200);
		} else {
			session()->flash('message', __('roles.Successfully saved permissions'));
			$result = redirect()->route('roles.index');
		}
		return $result;
	}
}