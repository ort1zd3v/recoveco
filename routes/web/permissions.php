<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permissions'])->group(function () {
	//Users
	Route::get('users/getbyparam', [UserController::class, 'getByParam'])->name('users.getbyparam');
	Route::get('users/getquickmodalcontent/{user?}', [UserController::class, 'getQuickModalContent'])->name('users.getquickmodalcontent');
	Route::get('users/{user}/permissions', [UserController::class, 'permissions'])->name('users.permissions');
	Route::post('users/{user}/save_permissions', [UserController::class, 'savePermissions'])->name('users.savePermissions');
	Route::resource('users', UserController::class);

	//Roles
	Route::get('roles/getquickmodalcontent/{role?}', [RoleController::class, 'getQuickModalContent'])->name('roles.getquickmodalcontent');
	Route::get('roles/{role}/permissions', [RoleController::class, 'permissions'])->name('roles.permissions');
	Route::post('roles/{role}/save_permissions', [RoleController::class, 'savePermissions'])->name('roles.savePermissions');
	Route::resource('roles', RoleController::class);
});