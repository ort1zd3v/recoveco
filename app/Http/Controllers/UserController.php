<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\PermissionModule;
use App\Models\PermissionPermissionUser;

use App\Http\Requests\UserRequest;
use App\DataTables\UserDataTable;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//Consultar permiso para botón de agregar
		$allowAdd = auth()->user()->hasPermissions("users.create");
		$allowEdit = auth()->user()->hasPermissions("users.edit");
		return (new UserDataTable())->render('users.index', compact('allowAdd', 'allowEdit'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$roles = Role::orderBy('name', 'asc')->pluck('name', 'id');
		
		return view('users.create', compact('roles'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(UserRequest $request)
	{
		$status = true;
		$user = null;
		$params = array_merge($request->all(), [
			'password' => bcrypt($request->password),
			'created_by' => auth()->id(),
			'updated_by' => auth()->id(),
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		try {
			$user = User::create($params);
			$message = __('users.Successfully created');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'users');
		}
		return $this->getResponse($status, $message, $user);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function show(User $user)
	{
		return view('users.show', compact('user'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function edit(User $user)
	{
		$roles = Role::orderBy('name', 'asc')->pluck('name', 'id');
		
		return view('users.edit', compact('user','roles'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function update(UserRequest $request, User $user)
	{
		$status = true;
		$params = array_merge($request->all(), [
			'updated_by' => auth()->id(),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		if($request->password !== null) {
			$params["password"] = bcrypt($request->password);
		}
		try {
			$user->update($params);
			$message = __('users.Successfully updated');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'users');
		}
		return $this->getResponse($status, $message, $user);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(User $user)
	{
		$status = true;
		try {
			$user->delete();
			$message = __('users.Successfully deleted');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'users');
		}
		return $this->getResponse($status, $message);
	}

	public function getQuickModalContent(User $user = null)
	{
		$params = request("params");
		$roles = Role::orderBy('name', 'asc')->pluck('name', 'id');
		
		return response()->json(view('crud-maker.components.modal-quickadd', compact('params', 'user','roles'))->render());
	}

	public function getByParam()
	{
		$result = User::getUser()
		->where("email", "like", "%".request("param")."%")
		->orWhere(DB::raw("CONCAT_WS(' ', name, paternal_surname, maternal_surname)"), "like", "%".request("param")."%")
		->get();
		return response()->json($result, 200);
	}
	
	public function permissions(User $user)
	{
		$permissionModules = (new PermissionModule)->permissionsByModule();
		$permissions = $user->permissionsArray();
		$permissionsParent = $user->role->permissionsArray();
		return view('users.permissions', compact('user', 'permissionModules', 'permissions', 'permissionsParent'));
	}

	public function savePermissions(Request $request, User $user)
	{
		if(isset($request["permissions"])) {
			PermissionPermissionUser::where("user_id", $user->id)->delete();
			foreach ($request["permissions"] as $key => $permission) {
				PermissionPermissionUser::create([
					'permission_id' => $key, 
					'user_id' => $user->id, 
					'created_at' => date("Y-m-d H:i:s"), 
					'updated_at' => date("Y-m-d H:i:s"),
				]);
				
			}
		}

		if($request->wantsJson()) {
			$result = response()->json(["message" => __('users.Successfully saved permissions'), "data" => $user], 200);
		} else {
			session()->flash('message', __('users.Successfully saved permissions'));
			$result = redirect()->route('users.index');
		}
		return $result;
	}
}
