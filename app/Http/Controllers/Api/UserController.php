<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{
	use RegistersUsers;

	public function show()
	{
		return Auth::user();
	}

	public function login(Request $request)
	{
		if (Auth::attempt([
			'email' => $request->email,
			'password' => $request->password
		])) {
			$user = $request->user();
			$user->token = $user->createToken('Leash')->accessToken;
			$user->access_token = $user->createToken('Leash')->accessToken;
			return $this->outputSuccess($user);
		} else {
			return response()
				->json([
					'error' => 'Unauthorized'
				], 401);
		}
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|unique:users',
			'password' => 'required|string|min:6|confirmed',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return \App\Models\User
	 */
	protected function create(array $data)
	{
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => Hash::make($data['password']),
		]);
	}
}
