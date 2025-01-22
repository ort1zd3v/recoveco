<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
	public function login()
	{
		$result = null;

		//Validar datos recibidos
		$validator = Validator::make(request()->all(), [
			'email' => 'required|string|email|max:255',
			'password' => 'required|min:6',
		]);
		if (!$validator->fails()) {
			//Buscar usuario en base de datos
			$user = User::where('email', request()->email)->first();
			if ($user) {
				//Comparar contraseña guardada con la contraseña ingresada
				if (Hash::check(request()->password, $user->password)) {
					//Crear token
					$token = $user->createToken('Laravel Password Grant Client');
					//Devolver usuario y token
					$result = response()->json([
						'status' => true,
						"user" => $user,
						"token_type" => "Bearer",
						"token" => $token->accessToken,
					], 200);
				} else {
					$result = response()->json([
						'status' => false,
						'message' => __('auth.password_mismatch'),
					], 422);
				}
			} else {
				$result = response()->json([
					'status' => false,
					'message' => __('auth.user_not_found'),
				], 422);
			}
		} else {
			$result = response()->json([
				'status' => false,
				'message' => __('auth.validation_error'),
				'errors' => $validator->errors()->all(),
			], 422);
		}

		return $result;
	}

	public function logout()
	{
		request()->user()->tokens()->delete();
		return response()->json([
			'status' => true,
			'message' => __("auth.logout_success")
		], 200);
	}

	public function passwordRecovery()
	{
		$result = null;
		$user = User::where('email', request()->email)->first();
		if ($user) {
			$user->sendEmailVerificationNotification();
			$result = response()->json([
				'status' => true,
				'message' => __("auth.email_sent")
			], 200);
		} else {
			$result = response()->json([
				'status' => false,
				'message' => __('auth.user_not_found'),
			], 422);
		}
		return $result;
	}
}
